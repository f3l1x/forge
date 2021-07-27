<?php
/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */

// #1 Load libraries
require __DIR__ . '/../vendor/autoload.php';

// 2# Create Nette Configurator
$configurator = new Nette\Configurator;

$configurator->setDebugMode(TRUE);
$configurator->enableDebugger(__DIR__ . '/cache/log');
$configurator->setTempDirectory(__DIR__ . '/cache/temp');

// 3# Create Nette Robot Loader
$configurator->createRobotLoader()
    ->addDirectory(__DIR__)
    ->register();

// 4# Load additionally configs
$configurator->addConfig(__DIR__ . '/config/config.neon', $configurator::AUTO);
$configurator->addConfig(__DIR__ . '/config/micro.neon');

// 5# Create container
$container = $configurator->createContainer();


// #6 Return container
return $container;