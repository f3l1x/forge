<?php
/**
 * Copyright (c) 2012 Milan Felix Sulc <rkfelix@gmail.com>
 */

use Nette\Utils\Strings;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 0.1
 */
class CleverRouter extends \Nette\Object{

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