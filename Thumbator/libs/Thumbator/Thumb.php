<?php

namespace Thumbator;

class Thumb extends \Nette\Object
{
    /** FILENAME FORMATS */

    /** md5 hash */
    const FILENAME_FORMAT_UNIQNAME = 00001;

    /** 120x500.jpg */
    const FILENAME_FORMAT_DIMENSION = 00010;

    /** customName */
    const FILENAME_FORMAT_VALUE = 00100;

    /** Original sanitized filename */
    const FILENAME_FORMAT_ORIGINAL = 01000;
    /** *************************************** */

    /** @var  */
    private $path;

    /** @var Dimension */
    private $dimension;

    /** @var int */
    private $flags = 00000;

    /** @var string */
    private $filename;

    /** @var string */
    private $originalName;

    /**
     * @param $width
     * @param $height
     * @param $path
     */
    public function __construct($width, $height, $path, $flags = self::FILENAME_FORMAT_UNIQNAME)
    {
        if ($width > 0 && $height > 0) {
            $this->dimension = new Dimension($width, $height);
            $this->path = $path;
            $this->flags = $flags;
        } else {
            throw new \Nette\InvalidArgumentException('Width or height must be a number');
        }
    }

    /**
     * @param \Dimension $dimension
     */
    public function setDimension($dimension)
    {
        $this->dimension = $dimension;
    }

    /**
     * @return \Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * @param  $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param int $flags
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;
    }

    /**
     * @return int
     */
    public function getFlags()
    {
        return $this->flags;
    }

    public function getImagename()
    {

        $filename = "";

        // CUSTOM VALUE
        if ($this->flags & self::FILENAME_FORMAT_VALUE) {
            $filename .= Utils::webalize($this->filename);
        }

        // ORIGINAL NAME
        if ($this->flags & self::FILENAME_FORMAT_ORIGINAL) {
            $filename .= Utils::sanitized(strstr$this->originalName);
        }
        // UNIQNAME
        if ($this->flags & self::FILENAME_FORMAT_UNIQNAME) {
            $filename .= md5($this->dimension->getWidth() . $this->dimension->getHeight(). $this->path . time());
        }

        // DIMENSIONS
        if ($this->flags & self::FILENAME_FORMAT_DIMENSION) {
            $filename .= $this->dimension->getWidth() . 'x' . $this->dimension->getHeight();
        }


        return $filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

}