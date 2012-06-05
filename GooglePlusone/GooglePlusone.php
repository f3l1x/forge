<?php
/*
 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * Version 2, December 2004
 * 
 * Copyright (C) 2011 - 2012 Milan Felix Sulc <rkfelix@gmail.com>
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

class GooglePlusone extends Nette\Object { 

    /**
     * Size constants
     */

	const SIZE_SMALL = "small";
	const SIZE_MEDIUM = "medium";
	const SIZE_STANDART = "standart";
	const SIZE_TALL = "tall";

    /**
     * Annotation constants
     */
	const ANNOTATION_INLINE = "inline";
	const ANNOTATION_BUBBLE = "bubble";
	const ANNOTATION_NONE = "none";

    /**
     * Google url
     */
	const GOOGLE_PLUSONE_URL = 'https://apis.google.com/js/plusone.js';

    /**
     * @var string
     */
	public $size = self::SIZE_STANDART;

    /**
     * @var string
     */
	public $annotation = self::ANNOTATION_INLINE;

    /**
     * @var string|null
     */
    private $callback = null;

    /**
     * @var string
     */
    private $url;

    /**
     * @var bool
     */
    private $html5 = FALSE;

    /**
     * @var string
     */
    private $lang = 'cs';

    /**
     * @var bool
     */
	private $asynchronous = FALSE;

    /**
     * Renders Google +1 button
     */
    public function render() {

        // Checks for html5 way..
		if ($this->html5) {
			$el = Nette\Utils\Html::el('div class=g-plusone');
		} else {
			$el = Nette\Utils\Html::el('g:plusone');
		}
		
		$el->size = $this->size;
		$el->annotation = $this->annotation;
		
		if (!is_null($this->callback)) {
			$el->callback = $this->callback;
		}
		
		if ($this->url) {
			$el->href = $this->url;
		}
		
		echo $el;
	}

    /**
     * Alias for renderJavascript
     */
    public function renderJs() {
		$this->renderJavascript();
	}

    /**
     * Renders important google script
     */
    public function renderJavascript() {
		
		if ($this->asynchronous) {
			$el = Nette\Utils\Html::el('script type="text/javascript"');
			$el->add("window.___gcfg = {lang: '".$this->lang."'};");
			$el->add("(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();");
					
			echo $el;
		} else {
			$el = Nette\Utils\Html::el('script type="text/javascript"');
			$el->src = self::GOOGLE_PLUSONE_URL;
			$el->add("{lang: '".$this->lang."'}");
			
			echo $el;
		} 
	}

    /**
     * @param $annotation
     * @return GooglePlusone
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * @param $asynchronous
     * @return GooglePlusone
     */
    public function setAsynchronous($asynchronous)
    {
        $this->asynchronous = $asynchronous;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAsynchronous()
    {
        return $this->asynchronous;
    }

    /**
     * @param $callback
     * @return GooglePlusone
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param $html5
     * @return GooglePlusone
     */
    public function setHtml5($html5)
    {
        $this->html5 = $html5;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isHtml5()
    {
        return $this->html5;
    }

    /**
     * @param $lang
     * @return GooglePlusone
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param $size
     * @return GooglePlusone
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param $url
     * @return GooglePlusone
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


}
