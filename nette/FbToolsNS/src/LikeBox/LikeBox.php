<?php
/**
 * FbTools 2.0 for PHP 5.3
 *
 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * Version 2, December 2004
 *
 * Copyright (C) 2011 Milan Felix Sulc <rkfelix[at]gmail.com>
 *
 * Everyone is permitted to copy and distribute verbatim or modified
 * copies of this license document, and changing it is allowed as long
 * as the name is changed.
 *
 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 *
 */

namespace FbTools;

class LikeBox extends FbTools
{

    /** @var int */
    public $height = 100;

    /** @var bool */
    public $faces = false;

    /** @var string */
    public $borderColor = "white";

    /** @var bool */
    public $stream = true;

    /** @var bool */
    public $header = true;

    public function render($params = array())
    {
        $this->setAll($params);
        // template vars
        $this->template->setFile(dirname(__FILE__) . '/LikeBox.latte');
        $this->template->url = $this->getUrl();
        $this->template->width = $this->getWidth();
        $this->template->height = $this->getHeight();
        $this->template->scheme = $this->getScheme();
        $this->template->faces = ($this->getFaces() ? "true" : "false");
        $this->template->borderColor = $this->getBorderColor();
        $this->template->stream = ($this->getStream() ? "true" : "false");
        $this->template->header = ($this->getHeader() ? "true" : "false");
        $this->template->html5 = $this->isHtml5();
        $this->template->render();
    }

    /**
     * @param boolean $faces
     */
    public function setFaces($faces)
    {
        $this->faces = $faces;
    }

    /**
     * @return boolean
     */
    public function getFaces()
    {
        return $this->faces;
    }

    /**
     * @param string $borderColor
     */
    public function setBorderColor($borderColor)
    {
        $this->borderColor = $borderColor;
    }

    /**
     * @return string
     */
    public function getBorderColor()
    {
        return $this->borderColor;
    }

    /**
     * @param boolean $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return boolean
     */
    public function getHeader()
    {
        return $this->header;
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
     * @param boolean $stream
     */
    public function setStream($stream)
    {
        $this->stream = $stream;
    }

    /**
     * @return boolean
     */
    public function getStream()
    {
        return $this->stream;
    }

}