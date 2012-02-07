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

class LikeButton extends FbTools
{

    /** @var bool */
    public $send = true;

    /** @var string */
    public $layout = "standart";

    /** @var bool */
    public $faces = false;

    /** @var string */
    public $display = "like";

    public function render($params = array())
    {
        $this->setAll($params);
        // template vars
        $this->template->setFile(dirname(__FILE__) . '/LikeButton.latte');
        $this->template->url = $this->getUrl();
        $this->template->send = ($this->getSend() ? "true" : "false");
        $this->template->layout = $this->getLayout();
        $this->template->width = $this->getWidth();
        $this->template->scheme = $this->getScheme();
        $this->template->font = $this->getFont();
        $this->template->display = $this->getDisplay();
        $this->template->faces = ($this->getFaces() ? "true" : "false");
        $this->template->html5 = $this->isHtml5();
        $this->template->render();
    }
	
	public function renderFaces($params = array()) 
	{
		$this->setLayout('standart'); // required!
		$this->setFaces(true);
		$this->render($params);
	}
	
	public function renderButton($params = array()) 
	{
		$this->setLayout('button_count');
		$this->render($params);
	}
	
	public function renderBox($params = array()) 
	{
		$this->setLayout('box_count');
		$this->render($params);
	}	
	
    /**
     * @param boolean $faces
     */
    public function setFaces($faces)
    {
        $this->faces = $faces;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getFaces()
    {
        return $this->faces;
    }


    /**
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }


    /**
     * @param boolean $send
     */
    public function setSend($send)
    {
        $this->send = $send;
        if ($send) { // required!!!
            $this->setHtml5(true);
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getSend()
    {
        return $this->send;
    }

    /**
     * @param string $display
     */
    public function setDisplay($display)
    {
        $this->display = $display;
    }

    /**
     * @return string
     */
    public function getDisplay()
    {
        return $this->display;
    }

}