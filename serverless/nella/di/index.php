<?php declare(strict_types = 1);

use Nette\DI\Compiler;
use Nette\DI\Config\Adapters\NeonAdapter;
use Nette\DI\ContainerLoader;
use Nette\Neon\Neon;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/utils.php';

$tempDir = '/tmp';

$containerLoader = new ContainerLoader($tempDir, true);
$containerClass = $containerLoader->load(function (Compiler $compiler): void {
	$input = getInput();
	$loader = new NeonAdapter();
	$config = $loader->process((array) Neon::decode($input));
	$compiler->addConfig($config);
}, 'nella');

$output = [
	'container' => file_get_contents($tempDir . '/' . $containerClass . '.php'),
];

header('Content-Type: application/json');
echo json_encode($output);
