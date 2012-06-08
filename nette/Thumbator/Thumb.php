<?php

class Thumb extends \Nette\Object
{

    /** @var  */
    private $path;

    /** @var Dimension */
    private $dimension;

    /**
     * @param $width
     * @param $height
     * @param $path
     */
    public function __construct($width, $height, $path)
    {
        if ($width > 0 && $height > 0) {
            $this->width = $width;
            $this->height = $height;
            $this->path = $path;
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
}