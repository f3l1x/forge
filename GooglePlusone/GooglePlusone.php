<?php
/*
 * DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * Version 2, December 2004
 * 
 * Copyright (C) 2011 Milan Felix Sulc <rkfelix@gmail.com>
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
	
	const SIZE_SMALL = "small";
	const SIZE_MEDIUM = "medium";
	const SIZE_STANDART = "standart";
	const SIZE_TALL = "tall";
	
	const ANNOTATION_INLINE = "inline";
	const ANNOTATION_BUBBLE = "bubble";
	const ANNOTATION_NONE = "none";
	
	const GOOGLE_PLUSONE_URL = 'https://apis.google.com/js/plusone.js';
	
	public $size = self::SIZE_STANDART;
	public $annotation = self::ANNOTATION_INLINE;
	public $callback = null;
	public $url;
	public $html5 = FALSE;
	public $lang = 'cs';
	public $asynchronous = FALSE;
	
	public function render() {
		
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

	public function renderJs() {
		$this->renderJavascript();
	}
	
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
	
	public function useHtml5() {
		$this->html5 = TRUE;
		return $this;
	}
	
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}
	
	public function setAnnotation($annotation) {
		$this->annotation = $annotation;
		return $this;
	}
	
	public function setSize($size) {
		$this->size = $size;
		return $this;
	}
	
	public function setCallback($callback) {
		$this->callback = $callback;
		return $this;
	}
	
	public function setAsynchronous($asyn) {
		$this->asynchronous = (boolean) $asyn;
		return $this;
	}
	
	public function setLang($lang) {
		$this->lang = $lang;
		return $this;
	}
	
}
