<?php
/**
 * Copyright (c) 2012 Milan Felix Sulc <rkfelix@gmail.com>
 */
use Nette\Application\UI\Control;
use Nette\Utils\Html;

/**
 * GooglePlusone component
 *
 * @author Milan Felix Sulc
 * @author Petr Stuchl4n3k Stuchlik
 * @version 1.2
 */
class GooglePlusone extends Control
{

    /** Size constants */
    const SIZE_SMALL = "small";
    const SIZE_MEDIUM = "medium";
    const SIZE_STANDART = "standart";
    const SIZE_TALL = "tall";

    /** Annotation constants */
    const ANNOTATION_INLINE = "inline";
    const ANNOTATION_BUBBLE = "bubble";
    const ANNOTATION_NONE = "none";

    /** Google URL */
    const GOOGLE_PLUSONE_URL = 'https://apis.google.com/js/plusone.js';

    /** @var string */
    public $size = self::SIZE_STANDART;

    /** @var string */
    public $annotation = self::ANNOTATION_INLINE;

    /** @var string|null */
    private $callback = NULL;

    /** @var */
    private $url;

    /** @var bool */
    private $html5 = FALSE;

    /** @var string */
    private $lang = 'cs';

    /** @var bool */
    private $asynchronous = FALSE;

    /** SETTERS/GETTERS ********************************************************************************************* */

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

    /** RENDERERS *****************************************************************************************************/

    /**
     * Render Google +1 button
     *
     * @return Nette\Utils\Html
     */
    public function render()
    {
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

        return $el;
    }

    /**
     * Alias for renderJavascript
     *
     * @return Nette\Utils\Html
     */
    public function renderJs()
    {
        return $this->renderJavascript();
    }

    /**
     * Render important google script
     *
     * @return Nette\Utils\Html
     */
    public function renderJavascript()
    {
        // Checks for asynchronous or classic
        if ($this->asynchronous) {
            $el = Html::el('script type="text/javascript"');
            $el->add("window.___gcfg = {lang: '" . $this->lang . "'};");
            $el->add("(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();");

            return $el;
        } else {
            $el = Html::el('script type="text/javascript"');
            $el->src = self::GOOGLE_PLUSONE_URL;
            $el->add("{lang: '" . $this->lang . "'}");

            return $el;
        }
    }

}
