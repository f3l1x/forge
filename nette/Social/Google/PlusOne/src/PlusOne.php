<?php
/**
 * Copyright (c) 2012 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Social;

use Nette\Application\UI\Control;
use Nette\Utils\Html;

/**
 * Google +1 component
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @author Petr Stuchl4n3k Stuchlik <stuchl4n3k@gmail.com>
 * @licence MIT
 * @version 1.3
 */
class PlusOne extends Control
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

    /** Render modes */
    const MODE_NORMAL = 1;
    const MODE_HTML5 = 2;

    /** Google URL */
    const GOOGLE_PLUSONE_URL = 'https://apis.google.com/js/plusone.js';

    /** @var string */
    public $size = self::SIZE_STANDART;

    /** @var string */
    public $annotation = self::ANNOTATION_INLINE;

    /** @var string|null */
    private $callback = NULL;

    /** @var string */
    private $url;

    /** @var int */
    private $mode = self::MODE_NORMAL;

    /** @var string */
    private $lang = 'cs';

    /** @var bool */
    private $asynchronous = FALSE;

    /** SETTERS/GETTERS ********************************************************************************************* */

    /**
     * @param string $annotation
     * @return self
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
     * @param string $asynchronous
     * @return self
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
     * @param string $callback
     * @return self
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
     * @param int $mode
     * @return self
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $lang
     * @return self
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
     * @param string $size
     * @return self
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
     * @param string $url
     * @return self
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
     * @return Html
     */
    public function render()
    {
        // Checks for html5 mode
        if ($this->mode == self::MODE_HTML5) {
            $el = Html::el('div class=g-plusone');
        } else {
            $el = Html::el('g:plusone');
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
     * Render important google script
     *
     * @return Html
     */
    public function renderJs()
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
