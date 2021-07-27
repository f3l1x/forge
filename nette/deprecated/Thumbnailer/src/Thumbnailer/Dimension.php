<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Thumbnailer;

use Nette\InvalidArgumentException;
use Nette\Utils\Image;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */
class Dimension extends \Nette\Object
{

    /** @var int */
    private $width = 0;

    /** @var int */
    private $height = 0;

    /** @var int */
    private $flag = Image::FILL;

    /**
     * @param int $width
     * @param int $height
     * @param int $flag
     */
    public function __construct($width, $height, $flag = Image::FILL)
    {
        if ($width > 0 && $height > 0) {
            $this->width = $width;
            $this->height = $height;
            $this->flag = $flag;
        } else {
            throw new InvalidArgumentException('Width or height must be a number');
        }
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * @return int
     */
    public function getFlag()
    {
        return $this->flag;
    }
}