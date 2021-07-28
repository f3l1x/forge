<?php

use Nette\Application\ApplicationException;
use Nette\Application\UI\Presenter;
use Nette\Caching\Cache;
use Nette\Loaders\RobotLoader;
use Nette\Reflection\Method;
use Nette\Utils\Strings;
use Tracy\Debugger;

class CronPresenter extends Presenter
{

    const TOKEN = 1234;

    /** @var array */
    private $methods = [];

    /** @var Cache */
    private $cache;

    public function startup()
    {
        parent::startup();

        // Validating part
        if (!$this->validate()) {
            throw new ApplicationException('Bad token');
        }

        // Booting, analyzing
        $this->boot();

        // Invoking part
        $this->invoke($this->methods);
    }

    /**
     * @return Cache
     */
    public function getCache()
    {
        if (!$this->cache) {
            $this->cache = new Cache($this->context->cacheStorage, 'cron');
        }

        return $this->cache;
    }

    /**
     * Validate user permission
     *
     * @return bool
     */
    private function validate()
    {
        if ($this->getParameter('token') == self::TOKEN) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Check list of methods
     */
    private function boot()
    {
        $this->methods = $this->getCache()->load('methods', callback($this, 'createMethodList'));
    }

    /**
     * Invoke all cron methods
     */
    private function invoke(array $methods)
    {
        foreach ($methods as $method) {

            Debugger::barDump($method->annotations, $method->name);
            $instance = $this->context->createInstance($method->class);
            callback($instance, $method->name)->invokeArgs([$this->context, $this->getParameters()]);
        }
    }

    /**
     * Creates method list
     * (may take a time..)
     *
     * @return array
     */
    public function createMethodList()
    {
        /** @var $robotLoader RobotLoader */
        $robotLoader = $this->context->getService('robotLoader');

        foreach ($robotLoader->getIndexedClasses() as $class => $file) {

            if (Strings::match($file, "~\Nette~")) continue;

            $creflection = new Nette\Reflection\ClassType($class);

            foreach ($creflection->getMethods() as $method) {
                $mreflection = new Method($class, $method->getName());

                if ($mreflection->hasAnnotation('cron')) {
                    $m = new stdClass();
                    $m->name = $mreflection->getName();
                    $m->class = $mreflection->getDeclaringClass()->getName();
                    $m->annotations = $mreflection->getAnnotations();
                    $this->methods[] = $m;
                }
            }
        }

        return $this->methods;
    }

}