<?php declare(strict_types = 1);

use Nette\Security\Passwords;

require_once __DIR__ . '/vendor/autoload.php';

function getInput()
{
	if (isset($_POST['password'])) {
		return $_POST['password'];
	} else if (isset($_GET['password'])) {
		return $_GET['password'];
	}

	return '';
}

$output = [
	'password' => Passwords::hash(getInput()),
];

header('Content-Type: application/json');
echo json_encode($output);
