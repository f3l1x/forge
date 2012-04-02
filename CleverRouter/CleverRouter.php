<?php
/*
 * CleverRouter
 *
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

use Nette\Utils\Strings;

class CleverRouter extends \Nette\Object{

    /** @var \Nette\DI\Container */
    private $context;

    /** @var array */
    private $routes = array();

    /**
     * @param $key
     * @param $value
     */
    public function add($key, $value)
    {
        $this->routes[$key] = $value;
    }

    /**
     * @param $url
     * @return array|null
     */
    public function urlIn($url)
    {
        $url = $this->cleanUp($url);
        if(isset($this->routes[$url])) {
            return $this->routes[$url];
        }
        return $url;
    }

    /**
     * @param $url
     * @return mixed|string
     */
    public function urlOut($url)
    {
        $url = $this->cleanUp($url);
        $key = array_search($url, $this->routes);
        return $key !== FALSE ? $key : $url;
    }

    /**
     * @param $url
     * @return mixed|string
     */
    public function cleanUp($url)
    {
        $parts = explode('/', $url);

        if (count($parts) <= 0) {
            return Strings::webalize($url);
        }

        for ($i = 0; $i < count($parts); $i++) {
            $p = Strings::webalize($parts[$i]);
            $parts[$i] = $p;
        }

        $url = implode('/', $parts);
        return $url;
    }
    
}