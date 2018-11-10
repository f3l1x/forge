<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->setDebugMode(TRUE); // enable for your remote IP
$configurator->enableTracy("/tmp");

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory("/tmp");

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

return $container;
