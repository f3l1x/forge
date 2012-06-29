<?php

class CronPresenter extends BasePresenter
{

    const TOKEN = 1234;

    /** @var array */
    private $methods = array();

    /** @var \Nette\Caching\Cache */
    private $cache;

    public function startup()
    {
        parent::startup();

        // Validating part
        if (!$this->validate()) {
            throw new \Nette\Application\ApplicationException('Bad token');
        }

        // Booting, analyzing
        $this->boot();

        // Invoking part
        $this->invoke($this->methods);
    }

    /**
     * @return Nette\Caching\Cache
     */
    public function getCache()
    {
        if (!$this->cache) {
            $this->cache = new \Nette\Caching\Cache($this->context->cacheStorage, 'cron');
        }

        return $this->cache;
    }

    /**
     * Validate user permission
     * @return bool
     */
    private function validate()
    {
        if ($this->getParameter('token') == self::TOKEN) {
            return true;
        }
        return false;
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

            \Nette\Diagnostics\Debugger::barDump($method->annotations, $method->name);
            $instance = $this->context->createInstance($method->class);
            callback($instance, $method->name)->invokeArgs(array($this->context, $this->getParameter()));
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
        /** @var $robotLoader \Nette\Loaders\RobotLoader */
        $robotLoader = $this->context->getService('robotLoader');

        foreach ($robotLoader->getIndexedClasses() as $class => $file) {

            if (\Nette\Utils\Strings::match($file, "~\Nette~")) continue;

            $creflection = new Nette\Reflection\ClassType($class);

            foreach ($creflection->getMethods() as $method) {
                $mreflection = new \Nette\Reflection\Method($class, $method->getName());

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