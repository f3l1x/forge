<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Social\Google;

use Nette\Application\UI\Control;
use Nette\Utils\Html;
use Nette\Utils\Validators;

/**
 * Google +1 component
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @author Petr Stuchl4n3k Stuchlik <stuchl4n3k@gmail.com>
 * @licence MIT
 * @version 2.0
 *
 * @property string $size
 * @property string $annotation
 * @property string $callback
 * @property string $url
 * @property int    $mode
 * @property int    $width
 * @property string $lang
 * @property Html   $elementPrototype
 * @property array  $properties
 */
class PlusOne extends Control
{

    /** Size constants */
    const SIZE_SMALL = "small";
    const SIZE_MEDIUM = "medium";
    const SIZE_STANDARD = "standard";
    const SIZE_TALL = "tall";

    /** Annotation constants */
    const ANNOTATION_INLINE = "inline";
    const ANNOTATION_BUBBLE = "bubble";
    const ANNOTATION_NONE = "none";

    /** Render modes */
    const MODE_DEFAULT = 1;
    const MODE_EXPLICIT = 2;
    const MODE_DYNAMIC = 3;

    /** Google platform URL */
    const GOOGLE_PLATFORM_URL = 'https://apis.google.com/js/platform.js';

    /** @var string */
    public $size = self::SIZE_STANDARD;

    /** @var string */
    public $annotation = self::ANNOTATION_INLINE;

    /** @var string */
    private $callback;

    /** @var string */
    private $url;

    /** @var int */
    private $mode = self::MODE_DEFAULT;

    /** @var int */
    private $width = 300;

    /** @var string */
    private $lang = 'cs';

    /** @var Html */
    private $element;

    /** @var array */
    private $properties = [];

    function __construct()
    {
        $this->element = Html::el('div class="g-plusone"');
    }

    /** SETTERS/GETTERS ***************************************************** */

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
        Validators::assert($url, 'string|url');
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

    /**
     * @param int $width
     * @return self
     */
    public function setWidth($width)
    {
        $this->width = intval($width);
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param Html $element
     */
    public function setElementPrototype($element)
    {
        $this->element = $element;
    }

    /**
     * @return Html
     */
    public function getElementPrototype()
    {
        return $this->element;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     * @return self
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return self
     */
    public function addProperty($name, $value)
    {
        $this->properties[$name] = $value;
        return $this;
    }

    /** RENDERERS *********************************************************** */

    /**
     * Render google +1 button
     *
     * @param string $url [optional]
     * @return Html
     */
    public function render($url = NULL)
    {
        // Get HTML element
        $el = $this->getElementPrototype();
        $el->size = $this->size;
        $el->annotation = $this->annotation;

        // Set given URL or filled url
        if ($url != NULL) {
            Validators::assert($url, 'string|url');
            $el->href = $url;
        } else {
            $el->href = $this->url;
        }

        // Set width in INLINE mode
        if ($this->annotation == self::ANNOTATION_INLINE) {
            $el->width = $this->width;
        }

        // Set callback, if filled
        if ($this->callback != NULL) {
            $el->callback = $this->callback;
        }

        // Set properties as data attributes
        foreach ($this->getProperties() as $key => $value) {
            if ($value !== NULL && !empty($value)) {
                $el->{"data-$key"} = $value;
            }
        }

        return $el;
    }

    /**
     * Render google javascript
     *
     * @return Html
     */
    public function renderJs()
    {
        if ($this->mode == self::MODE_DEFAULT) {
            $el = Html::el('script type="text/javascript" async defer');
            $el->src = self::GOOGLE_PLATFORM_URL;
            $el->add("{lang: '" . $this->lang . "'}");

            return $el;

        } else if ($this->mode == self::MODE_EXPLICIT) {
            $wrapper = Html::el();

            $el = Html::el('script type="text/javascript" async defer');
            $el->src = self::GOOGLE_PLATFORM_URL;
            $el->add("{lang: '" . $this->lang . "', parsetags: 'explicit'}");
            $wrapper->add($el);

            $el = Html::el('script type="text/javascript"');
            $el->add("gapi.plusone.go();");
            $wrapper->add($el);

            return $wrapper;

        } else if ($this->mode == self::MODE_DYNAMIC) {
            $el = Html::el('script type="text/javascript"');
            $el->add("window.___gcfg = {lang: '" . $this->lang . "'};");
            $el->add("(function(){var po=document.createElement('script');po.type='text/javascript';po.async=true;po.src='" . self::GOOGLE_PLATFORM_URL . "';vars=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(po, s);})();");

            return $el;
        }

        return NULL;
    }

}
