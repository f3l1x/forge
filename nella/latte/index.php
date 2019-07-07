<?php declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/utils.php';

use Latte\Engine;
use Latte\Loaders\StringLoader;

$input = getInput();
$params = getParams();

$engine = new Engine();
$engine->setAutoRefresh(false);
$engine->setLoader(new StringLoader());
$engine->setTempDirectory('/tmp');

$output = [
	'compile' => $engine->compile($input),
	'render' => $engine->renderToString($input, $params),
];

header('Content-Type: application/json');
echo json_encode($output);
