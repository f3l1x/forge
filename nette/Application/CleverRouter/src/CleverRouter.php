<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Router;

use Nette\Utils\Strings;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */
class CleverRouter
{

    /** @var array */
    private $routes = array();

    /**
     * @param string $key
     * @param string $value
     */
    public function add($key, $value)
    {
        $this->routes[$key] = $value;
    }

    /** FILTERS ***************************************************************************************************** */

    /**
     * @param string $url
     * @return mixed
     */
    public function urlIn($url)
    {
        // Normalize URL
        $url = $this->normalize($url);

        // Exists alias?
        if (isset($this->routes[$url])) return $this->routes[$url];

        // Return original
        return $url;
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function urlOut($url)
    {
        // Normalize URL
        $url = $this->normalize($url);

        // Exists alias?
        if (($key = array_search($url, $this->routes)) !== FALSE) return $key;

        // Return original
        return $url;
    }

    /** HELPERS ***************************************************************************************************** */

    /**
     * @param $url
     * @return mixed|string
     */
    private function normalize($url)
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