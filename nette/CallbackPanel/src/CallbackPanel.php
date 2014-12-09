<?php

namespace NettePlugins\Panels\CallbackPanel;

use Nette\Caching\Cache;
use Nette\DI\Container;
use Nette\Http\Request;
use Nette\Http\Session;
use Nette\InvalidArgumentException;
use Nette\InvalidStateException;
use Nette\Object;
use Nette\Utils\Callback;
use Nette\Utils\Finder;
use Tracy\Debugger;
use Tracy\IBarPanel;

/**
 * Callback panel for Nette Debugger Bar
 *
 * @copyright Copyright (c) 2010-2011 Patrik Votoček (Vrtak-CZ)
 * @copyright Copyright (c) 2012-2014 Milan Šulc (f3l1x)
 * @license MIT
 *
 * @method onCallbacksCall
 * @method onCallbackCall($callback)
 */
class CallbackPanel extends Object implements IBarPanel
{
    const VERSION = "2.2.0";

    /** @var array */
    public $onCallbackCall = [];

    /** @var array */
    public $onCallbacksCall = [];

    /** @var bool */
    private static $registered = FALSE;

    /** @var Container */
    private $container;

    /** @var array[name => string, callback => callable, args => array()] */
    private $callbacks;

    /** @var bool */
    private $active = TRUE;

    /**
     * @param Container $container
     * @param array $callbacks [optional]
     */
    public function __construct(Container $container, $callbacks = array())
    {
        $this->container = $container;

        /** @var $httpRequest Request */
        $request = $container->getService("httpRequest");

        // Determine production/development mode
        $this->active = !Debugger::$productionMode;

        // # Clean cache
        $this->callbacks["cache"] = array(
            'name' => "Clear cache",
            'callback' => Callback::closure($this, "clearCache"),
            'args' => array(array(Cache::ALL => TRUE)),
        );

        // # Clean session
        $this->callbacks["session"] = array(
            'name' => "Clear session",
            'callback' => Callback::closure($this, "clearSession"),
            'args' => array(),
        );

        // # Clean logs
        $this->callbacks["logs"] = array(
            'name' => "Clear logs",
            'callback' => Callback::closure($this, "clearLogs"),
            'args' => array(array(Cache::ALL => TRUE)),
        );

        // Merge custom callbacks
        $this->callbacks = array_merge($this->callbacks, $callbacks);

        // Check signal receiver
        if ($this->active && ($cb = $request->getQuery("callback-do", FALSE))) {
            if ($cb === "all") {
                $this->onCallbacksCall();
                $this->invokeCallbacks();
            } else {
                $this->onCallbackCall($cb);
                $this->invokeCallback($cb);
            }
        }
    }

    /**
     * Process signal and invoke callback
     *
     * @param string $name
     * @throws InvalidArgumentException
     * @return void
     */
    private function invokeCallback($name)
    {
        if (strlen($name) > 0 && array_key_exists($name, $this->callbacks)) {
            $this->callbacks[$name]['callback']->invokeArgs($this->callbacks[$name]['args']);
        } else {
            throw new InvalidArgumentException("Callback '" . $name . "' doesn't exist.");
        }
    }

    /**
     * Invoke all callbacks
     *
     * @return void
     */
    private function invokeCallbacks()
    {
        foreach ($this->callbacks as $callback) {
            $callback['callback']->invokeArgs($callback['args']);
        }
    }

    /** PREPARED CALLBACKS ********************************************************************************************/

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
        /** @var $session Session */
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
     * @throws InvalidArgumentException
     * @return void
     */
    public function clearLogs($args = array())
    {
        $folder = $this->container->parameters["logDir"];
        if (!is_dir($folder)) {
            throw new InvalidArgumentException("'" . $folder . "' is not folder or can't read/write");
        }
        foreach (Finder::findFiles('*')->exclude(".*")->from($folder)->exclude('.svn', '.git')->childFirst() as $entry) {
            if (is_dir($entry)) {
                @rmdir($entry); // safety
            } else if (is_file($entry)) {
                @unlink($entry); // safety
            }
        }
    }

    /** INTERFACE *****************************************************************************************************/

    /**
     * Returns if activated
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Renders HTML code for custom tab.
     *
     * @see IBarPanel::getTab()
     * @return string
     */
    public function getTab()
    {
        return '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAK8AAACvABQqw0mAAAABh0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzT7MfTgAAAY9JREFUOI2lkj1rVUEQhp93d49XjYiCUUFtgiBpFLyWFhKxEAsbGy0ErQQrG/EHCII/QMTGSrQ3hY1FijS5lQp2guBHCiFRSaLnnN0di3Pu9Rpy0IsDCwsz8+w776zMjP+J0JV48nrufMwrc2AUbt/CleMv5ycClHH1UZWWD4MRva4CByYDpHqjSgKEETcmHiHmItW5STuF/FfAg8HZvghHDDMpkKzYXScPgFcx9XBw4WImApITn26cejEAkJlxf7F/MOYfy8K3OJGtJlscKsCpAJqNGRknd+jO6TefA8B6WU1lMrBZ6fiE1R8Zs7hzVJHSjvJnNMb/hMSmht93IYIP5Qhw99zSx1vP+5eSxZmhzpzttmHTbcOKk+413Sav4v3J6ZsfRh5sFdefnnhr2Gz75rvHl18d3aquc43f1/BjaN9V1wn4tq6eta4LtnUCQuPWHmAv0AOKDNXstZln2/f3zgCUX8oFJx1zDagGSmA1mn2VmREk36pxw5NgzVqDhOTFLhjtOgMxmqVOE/81fgFilqPyaom5BAAAAABJRU5ErkJggg==">callback';
    }

    /**
     * Renders HTML code for custom panel.
     *
     * @see IBarPanel::getPanel()
     * @return string
     */
    public function getPanel()
    {
        $items = $this->callbacks;
        ob_start();
        require_once __DIR__ . "/CallbackPanel.phtml";
        return ob_get_clean();
    }

    /**
     * Register this panel
     *
     * @param Container $container
     * @param array $callbacks
     * @throws InvalidStateException
     * @return void
     */
    public static function register(Container $container, $callbacks = array())
    {
        if (self::$registered) {
            throw new InvalidStateException("Callback panel is already registered");
        }

        Debugger::getBar()->addPanel(new static($container, $callbacks));
        self::$registered = TRUE;
    }
}