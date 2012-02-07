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

use \Nette\DI\Container,
    \Nette\MemberAccessException,
    \Nette\Utils\Validators;

class FbTools extends \Nette\Application\UI\Control
{
    /** @var \Nette\Templating\Template */
    protected $template;

    /** @var SystemContainer */
    protected $context;

    /** @var int */
    public $appId = 123456789;

    /** @var bool */
    public $html5 = true;

    /** @var string */
    public $url = "http://www.example.com";

    /** @var boolean */
    public $autoUrl = false;

    /** @var int */
    public $width = 300;

    /** @var string */
    public $scheme = "light";

    /** @var string */
    public $font = "arial";

    function __construct($parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);

        $this->template = $this->createTemplate();
        $this->template->html5 = $this->html5;
        $this->template->appId = $this->appId;
    }

    /**
     * @param \Nette\DI\Container $context
     */
    public function setContext(Container $context)
    {
        $this->context = $context;
    }

    public function render()
    {
        $this->template->setFile(dirname(__FILE__) . '/fb.latte');
        $this->template->render();
    }

    /**
     * @param int $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param boolean $html5
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
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
        return $this;
    }

    /**
     * @param string $font
     */
    public function setFont($font)
    {
        $this->font = $font;
        return $this;
    }

    /**
     * @return string
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @param string $scheme
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param boolean $autoUrl
     */
    public function setAutoUrl($autoUrl)
    {
        $this->autoUrl = $autoUrl;
    }

    /**
     * @return boolean
     */
    public function isAutoUrl()
    {
        return $this->autoUrl;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if ($this->isAutoUrl()) {
            $url = $this->context->httpRequest->url;
        } else {
            $url = $this->url;
        }

        if (Validators::isUrl($url)) {
            return $url;
        } else {
            trigger_error('Url "' . $url . '" is not valid url address.!', E_USER_WARNING);
        }
    }

    /**
     * @param array $params
     */
    public function setAll($params = array())
    {
        try {
            foreach ($params as $name => $value) {
                $this->$name = $value;
            }
        } catch (MemberAccessException $e) {
            trigger_error('Unknown setter set' . ucfirst($name) . '() in ' . __CLASS__ . ' package.', E_USER_WARNING);
        }
    }
}
