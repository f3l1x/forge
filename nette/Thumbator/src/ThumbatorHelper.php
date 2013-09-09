<?php
/**
 * Copyright (c) 2013 Milan Felix Sulc <rkfelix@gmail.com>
 */

use Nette\Object;
use Nette\Image;

/**
 * Thumbator helper - prepare helper for Latte
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.1
 */

class ThumbatorHelper extends Object
{

    /** @var Thumbator */
    private $thumbator;

    /**
     * @param Thumbator $thumbator
     */
    function __construct(Thumbator $thumbator)
    {
        $this->thumbator = $thumbator;
    }

    /**
     * @param string $src
     * @param int $width
     * @param int $height
     * @param null $mode
     */
    public function image($src, $width, $height, $mode = Image::SHRINK_ONLY)
    {
        $this->thumbator->create($src, $width, $height, $mode);
    }
}