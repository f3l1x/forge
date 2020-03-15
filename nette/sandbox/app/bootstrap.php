<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$tempDir = $_ENV['NOW_REGION'] ? '/tmp' : __DIR__ . '/../temp';

$configurator->setDebugMode(TRUE); // enable for your remote IP
$configurator->enableTracy($tempDir);

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory($tempDir);

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

return $container;
