<?php
/**
 * Copyright (c) 2013 Milan Felix Sulc <rkfelix@gmail.com>
 */

use Nette\Image;

/**
 * Thumbator - easy-use util for resizing images on website
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */
class Thumbator extends \Nette\Object
{

    /** @var \Nette\Http\Request */
    private $httpRequest;

    /** @var string */
    private $thumbDir;

    /** @var string */
    private $storageDir;

    /** @var string */
    private $wwwDir;

    /** @var array */
    private static $methods = array('shrink', 'exact');

    /** @var string */
    private $placeholditUrl = "http://placehold.it/%ux%u";

    /** @var bool */
    private $silentMode = TRUE;

    /**
     * @param \Nette\Http\Request $httpRequest
     */
    function __construct(\Nette\Http\Request $httpRequest)
    {
        $this->httpRequest = $httpRequest;
    }

    /** GETTERS/SETTERS ********************************************************************************************* */

    /**
     * @param string $storageDir
     */
    public function setStorageDir($storageDir)
    {
        $this->storageDir = $storageDir;
    }

    /**
     * @return string
     */
    public function getStorageDir()
    {
        return $this->storageDir;
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
     * @param string $wwwDir
     */
    public function setWwwDir($wwwDir)
    {
        $this->wwwDir = $wwwDir;
    }

    /**
     * @return string
     */
    public function getWwwDir()
    {
        return $this->wwwDir;
    }

    /**
     * @param boolean $silentMode
     */
    public function setSilentMode($silentMode)
    {
        $this->silentMode = $silentMode;
    }

    /**
     * @return boolean
     */
    public function getSilentMode()
    {
        return $this->silentMode;
    }

    /** HELPERS ***************************************************************************************************** */

    /**
     * @return string
     */
    private function getBasePath()
    {
        return $this->httpRequest->url->basePath;
    }

    /**
     * @param $width
     * @param $height
     * @return string
     */
    private function placeholdit($width, $height)
    {
        return sprintf($this->placeholditUrl, $width, $height);
    }

    /**
     * @param $path
     */
    private static function mkdir($path)
    {
        @mkdir($path, 0777, TRUE);
    }

    /** API ********************************************************************************************************* */

    public function create($file, $width = NULL, $height = NULL, $method = 'shrink')
    {
        // Validate given file
        if ($file == NULL || !$file) {
            throw new \Nette\InvalidStateException("Invalid file given!");
        }

        // Validate height and width
        if (!$height && !$width) {
            throw new \Nette\InvalidStateException("Both params height and width can't be empty!");
        }

        // Validate method
        if (!in_array($method, self::$methods)) {
            throw new \Nette\InvalidStateException("Unknown resize method!");
        }

        // Absolute path to original file
        $original = $this->getStorageDir() . '/' . $file;
        // Generated thumb path
        $path = $this->getThumbDir() . '/' . $width . 'h_' . $height . "w/$method/";
        // Relative path to thumb
        $thumb = $path . $file;
        // Absolute path to thumb
        $thumbabs = $this->getWwwDir() . '/' . $thumb;

        // Exist original file?
        if (!file_exists($original)) {
            if ($this->silentMode) {
                return $this->placeholdit($width, $height);
            } else {
                throw new \Nette\InvalidStateException("Original file does not exist!");
            }
        }

        // Exist thumb?
        if (!file_exists($thumbabs)) {
            try {
                /** @var $image Image */
                $image = Image::fromFile($original);
            } catch (\Nette\UnknownImageFileException $e) {
                throw new \Nette\InvalidStateException("Image: loading image error, original file probably does not exist!");
            }

            // Create dirs
            self::mkdir(dirname($thumbabs));

            // Resize image
            switch ($method) {
                case 'shrink':
                    $this->resizeShrink($image, $width, $height);
                    break;
                case 'exact':
                    $this->resizeExact($image, $width, $height);
                    break;
            }

            $image->save($thumbabs);
            unset($image);
        }

        return $this->getBasePath() . $thumb;
    }

    /**
     * @param Image $image
     * @param $width
     * @param $height
     */
    private function resizeShrink(Image &$image, $width, $height)
    {
        $image->resize($width, $height, Image::SHRINK_ONLY);
    }

    /**
     * @param Image $image
     * @param $width
     * @param $height
     */
    private function resizeExact(Image &$image, $width, $height)
    {
        $image->resize($width, $height, Image::EXACT);
    }

}