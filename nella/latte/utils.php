<?php declare(strict_types = 1);

function getInput(): string
{
	if ($_POST['input']) {
		$input = json_decode($_POST['input']);
	} elseif ($_GET['input']) {
		$input = base64_decode($_GET['input']);
	} else {
		$input = '';
	}

	return $input;
}

function getParams(): array
{
	if ($_POST['params']) {
		$params = json_decode($_POST['params']);
	} elseif ($_GET['params']) {
		$params = json_decode(base64_decode($_GET['params']));
	} else {
		$params = [];
	}

	return $params;
}