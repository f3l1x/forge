<?php

namespace Addons\Panels;

/**
 * Callback panel for nette debugbar
 *
 * @copyright Copyright (c) 2010, 2011 Patrik Votoček (Vrtak-CZ)
 * @copyright Copyright (c) 2012 Milan Šulc
 * @license MIT
 */
class Callback extends \Nette\Object implements \Nette\Diagnostics\IBarPanel
{
    const VERSION = "2.1";

    /** @var bool */
    private static $registered = FALSE;

    /** @var \Nette\DI\Container */
    private $container;

    /** @var array[name => string, callback => callable, args => array()] */
    private $callbacks;

    /**
     * @param \Nette\DI\Container $container
     */
    public function __construct(\Nette\DI\Container $container, $callbacks = array())
    {
        $this->container = $container;
        /** @var $httpRequest \Nette\Http\Request */
        $request = $container->getService("httpRequest");

        // Prepared callbacks
        // # Clean cache
        $this->callbacks["cache"] = array(
            'name' => "Clear cache",
            'callback' => callback($this, "clearCache"),
            'args' => array(array(\Nette\Caching\Cache::ALL => TRUE)),
        );
        // # Clean session
        $this->callbacks["session"] = array(
            'name' => "Clear session",
            'callback' => callback($this, "clearSession"),
            'args' => array(),
        );
        // # Clean logs
        $this->callbacks["logs"] = array(
            'name' => "Clear logs",
            'callback' => callback($this, "clearLogs"),
            'args' => array(array(\Nette\Caching\Cache::ALL => TRUE)),
        );

        // Merge custom callbacks
        $this->callbacks = array_merge($this->callbacks, $callbacks);

        // Check signal receiver
        if (($cb = $request->getQuery("callback-do", false))) {
            if ($cb === "all") {
                $this->invokeCallbacks();
            } else {
                $this->invokeCallback($cb);
            }
        }
    }

    /**
     * Process signal and invoke callback
     *
     * @param $name
     * @throws \InvalidArgumentException
     * @return void
     */
    private function invokeCallback($name)
    {
        if (strlen($name) > 0 && array_key_exists($name, $this->callbacks)) {
            $this->callbacks[$name]['callback']->invokeArgs($this->callbacks[$name]['args']);
        } else {
            throw new \InvalidArgumentException("Callback '" . $name . "' doesn't exist.");
        }
    }

    /**
     * Invoke all callbacks
     */
    private function invokeCallbacks() {
        foreach ($this->callbacks as $callback) {
            $callback['callback']->invokeArgs($callback['args']);
        }
    }

    /** *********************************** PREPARED CALLBACK *********************************** */

    /**
     * Clear cache storage (temp/cache)
     *
     * @param array $args
     * @return void
     */
    public function clearCache($args = array())
    {
        $this->container->getService("cacheStorage")->clean($args);
    }

    /**
     * Clear session storage
     *
     * @param array $args
     * @return void
     */
    public function clearSession($args = array())
    {
        /** @var $session \Nette\Http\Session */
        $session = $this->container->getService("session");
        if (!$session->isStarted()) {
            $session->clean();
        } else {
            $session->destroy();
            $session->start();
        }
    }

    /**
     * Clear logs folder
     *
     * @param array $args
     * @return void
     */
    public function clearLogs($args = array())
    {
        $folder = $this->container->parameters["logDir"];
        if (!is_dir($folder)) {
            throw new \InvalidArgumentException("'" . $folder . "' is not folder or can't read/write");
        }
        foreach (\Nette\Utils\Finder::findFiles('*')->exclude(".*")->from($folder)->exclude('.svn', '.git')->childFirst() as $entry) {
            if (is_dir($entry)) {
                @rmdir($entry); // safety
            } else if (is_file($entry)) {
                @unlink($entry); // safety
            }
        }
    }

    /** *********************************** INTERFACE *********************************** */

    /**
     * Renders HTML code for custom tab.
     *
     * @return string
     * @see \Nette\Diagnostics\IBarPanel::getTab()
     */
    public function getTab()
    {
        return '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAK8AAACvABQqw0mAAAABh0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzT7MfTgAAAY9JREFUOI2lkj1rVUEQhp93d49XjYiCUUFtgiBpFLyWFhKxEAsbGy0ErQQrG/EHCII/QMTGSrQ3hY1FijS5lQp2guBHCiFRSaLnnN0di3Pu9Rpy0IsDCwsz8+w776zMjP+J0JV48nrufMwrc2AUbt/CleMv5ycClHH1UZWWD4MRva4CByYDpHqjSgKEETcmHiHmItW5STuF/FfAg8HZvghHDDMpkKzYXScPgFcx9XBw4WImApITn26cejEAkJlxf7F/MOYfy8K3OJGtJlscKsCpAJqNGRknd+jO6TefA8B6WU1lMrBZ6fiE1R8Zs7hzVJHSjvJnNMb/hMSmht93IYIP5Qhw99zSx1vP+5eSxZmhzpzttmHTbcOKk+413Sav4v3J6ZsfRh5sFdefnnhr2Gz75rvHl18d3aquc43f1/BjaN9V1wn4tq6eta4LtnUCQuPWHmAv0AOKDNXstZln2/f3zgCUX8oFJx1zDagGSmA1mn2VmREk36pxw5NgzVqDhOTFLhjtOgMxmqVOE/81fgFilqPyaom5BAAAAABJRU5ErkJggg==">callback';
    }

    /**
     * Renders HTML code for custom panel.
     *
     * @return string
     * @see \Nette\Diagnostics\IBarPanel::getPanel()
     */
    public function getPanel()
    {
        $items = $this->callbacks;
        ob_start();
        require_once __DIR__ . "/Callback.phtml";
        return ob_get_clean();
    }

    /**
     * Register this panel
     *
     * @param array items for add to pannel
     * @return void
     */
    public static function register(\Nette\DI\Container $container, $callbacks = array())
    {
        if (self::$registered) {
            throw new \Nette\InvalidStateException("Callback panel is already registered");
        }

        \Nette\Diagnostics\Debugger::$bar->addPanel(new static($container, $callbacks));
        self::$registered = TRUE;
    }
}