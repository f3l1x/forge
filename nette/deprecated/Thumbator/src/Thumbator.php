<?php
/**
 * Copyright (c) 2013 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Thumbator;

use Nette\Http\Request;
use Nette\InvalidArgumentException;
use Nette\InvalidStateException;
use Nette\Object;
use Nette\Utils\Image;
use Nette\Utils\Strings;
use Nette\Utils\UnknownImageFileException;

/**
 * Thumbator - easy-use util for resizing images on website
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.1
 */
class Thumbator extends Object
{

    /** Thumbator modes */
    const MODE_STRICT = 1;
    const MODE_SILENT = 2;

    /** @var \Nette\Http\Request */
    private $httpRequest;

    /** @var string */
    private $wwwPath;

    /** @var string */
    private $thumbDir;

    /** @var string */
    private $placeholder = "http://placehold.it/%ux%u";

    /** @var int */
    private $mode = self::MODE_STRICT;

    /** @var string */
    private $mask = "%width%x%height%/%method%/%filename%.%ext%";

    /** @var array */
    private $maskHolders = array('%width%', '%height%', '%filename%', '%ext%', '%method%');

    /** @var bool */
    private $overwrite = FALSE;

    /** @var array of function(string $image) */
    public $onCreate;

    /** @var array of function(Image $original, string $image, int $width, int $height, int $method) */
    public $onResize;

    /** @var array of function(string $image, int $width, int $height, int $method) */
    public $onPlacehold;

    /**
     * @param Request $httpRequest
     */
    function __construct(Request $httpRequest)
    {
        $this->httpRequest = $httpRequest;
    }

    /** GETTERS/SETTERS ********************************************************************************************* */

    /**
     * @param string $mask
     */
    public function setMask($mask)
    {
        $this->mask = $mask;
    }

    /**
     * @return string
     */
    public function getMask()
    {
        return $this->mask;
    }

    /**
     * @param int $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param boolean $overwrite
     */
    public function setOverwrite($overwrite)
    {
        $this->overwrite = $overwrite;
    }

    /**
     * @return boolean
     */
    public function getOverwrite()
    {
        return $this->overwrite;
    }

    /**
     * @param string $placeholder
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param string $thumbDir
     */
    public function setThumbDir($thumbDir)
    {
        $this->thumbDir = $thumbDir;
    }

    /**
     * @return string
     */
    public function getThumbDir()
    {
        return $this->thumbDir;
    }

    /**
     * @param string $wwwPath
     */
    public function setWwwPath($wwwPath)
    {
        $this->wwwPath = $wwwPath;
    }

    /**
     * @return string
     */
    public function getWwwPath()
    {
        return $this->wwwPath;
    }

    /** HELPERS ***************************************************************************************************** */

    /**
     * @return string
     */
    protected function getBasePath()
    {
        return $this->httpRequest->url->basePath;
    }

    /**
     * @param string $original
     * @param int $width
     * @param int $height
     * @param null $filename
     * @param null $method
     * @return string
     */
    protected function placehold($original, $width, $height, $filename = NULL, $method = NULL)
    {
        try {
            $data = @file_get_contents(sprintf($this->placeholder, $width, $height, $filename, $method));
            if ($data) {
                $image = Image::fromString($data);
                $image->save($this->getWwwPath() . '/' . $original);
                return $this->create($filename, $width, $height, $method);
            }
        } catch (\Exception $e) {
            // Silent..
        }

        return sprintf($this->placeholder, $width, $height, $filename, $method);
    }

    /**
     * @param $path
     */
    protected static function mkdir($path)
    {
        @mkdir($path, 0777, TRUE);
    }

    /**
     * @param string $file
     * @param int $width
     * @param int $height
     * @param int $method
     * @return string
     */
    protected function mask($file, $width, $height, $method)
    {
        $pathinfo = pathinfo($file);
        $normalize = function ($n) {
            return intval($n);
        };
        $replacements = array($normalize($width), $normalize($height), $pathinfo['filename'], $pathinfo['extension'], $this->method2name($method));
        return str_replace($this->maskHolders, $replacements, $this->mask);
    }

    /**
     * @param int $method
     * @return string
     */
    protected static function method2name($method)
    {
        switch ($method) {
            case Image::SHRINK_ONLY:
                return 'shrink';
            case Image::FILL:
                return 'fill';
            case Image::FIT:
                return 'fit';
            case Image::STRETCH:
                return 'stretch';
            case Image::EXACT:
                return 'exact';
            default:
                return 'mix';
        }
    }

    /** API ********************************************************************************************************* */

    /**
     * @param string $file
     * @param int $width
     * @param int $height
     * @param int $method
     * @return string
     * @throws InvalidStateException
     * @throws InvalidArgumentException
     */
    public function create($file, $width = NULL, $height = NULL, $method = Image::EXACT)
    {
        // Validate given file
        if ($file == NULL || !$file) {
            throw new InvalidArgumentException("Invalid file given!");
        }

        // Validate height and width
        if (!$height && !$width) {
            throw new InvalidArgumentException("Both params height and width can't be empty!");
        }

        // Absolute path to original file
        $original = $this->getWwwPath() . '/' . $file;

        // Webalize filename
        $filename = Strings::webalize($file, '.');

        // Generate mask
        $mask = $this->getThumbDir() . '/' . $this->mask($filename, $width, $height, $method);

        // Absolute path to thumb
        $thumb = $this->getWwwPath() . '/' . $mask;

        // Exist original file?
        if (!file_exists($original)) {
            if ($this->mode == self::MODE_SILENT) {
                $this->onPlacehold($file, $width, $height, $method);
                return $this->placehold($file, $width, $height, $filename, $method);
            } else {
                throw new InvalidStateException("Original file ($original) does not exist!");
            }
        }

        // Exist thumb?
        if (!file_exists($thumb) || (filemtime($original) < filemtime($thumb))) {
            try {
                /** @var $image Image */
                $this->onCreate($original);
                $image = Image::fromFile($original);
            } catch (UnknownImageFileException $e) {
                throw new InvalidStateException("Image: loading image error!");
            }

            // Create dirs
            self::mkdir(dirname($thumb));

            // Resize image to thumb
            $this->onResize($image, $thumb, $width, $height, $method);
            $image->resize($width, $height, $method);

            // Save thumb
            $image->save($thumb);

            // Clear pointers, variables, stats..
            unset($image);
            clearstatcache();
        }

        return $this->getBasePath() . $mask;
    }

}