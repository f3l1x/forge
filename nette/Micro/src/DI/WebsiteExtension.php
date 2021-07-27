<?php

namespace Minetro\Micro\Modules\Website\DI;

use Nette;
use Nette\DI\CompilerExtension;

/**
 * Micro extension.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class WebsiteExtension extends CompilerExtension
{
    /** @var array */
    public $defaults = [
        'debug' => '%debugMode%',
        'routes' => [],
        'closures' => [],
        'config' => [
            'templates' => '%appDir%\templates',
        ]
    ];

    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->getConfig($this->defaults);

        $builder->addDefinition($this->prefix('parameters'))
            ->setClass('Minetro\Micro\DI\Parameters')
            ->setArguments([$config]);

        foreach ($config['routes'] as $key => $route) {
            $builder->addDefinition($this->prefix('routes' . $key))
                ->setClass($route)
                ->setInject(TRUE);
        }

        foreach ($config['closures'] as $key => $closure) {
            $builder->addDefinition($this->prefix('closure' . $key))
                ->setClass($closure)
                ->setAutowired(TRUE)
                ->setInject(TRUE);
        }

        $router = $builder->addDefinition($this->prefix('router'))
            ->setClass('Minetro\Micro\Routing\RouterManager');

        foreach ($config['routes'] as $key => $route) {
            $router->addSetup('addProvider', ['@' . $this->prefix('routes' . $key)]);
        }

        $builder->getDefinition('router')
            ->addSetup('@' . $this->prefix('router') . '::create', ['@self']);

        if ($config['debug']) {
            $builder->addDefinition($this->prefix('debug'))
                ->setClass('Minetro\Micro\Debug\ApplicationDebug')
                ->addTag('run');
        }
    }

    public function beforeCompile()
    {
    }

    public function afterCompile(Nette\PhpGenerator\ClassType $class)
    {
    }

}