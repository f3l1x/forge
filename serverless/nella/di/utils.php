<?php declare(strict_types = 1);

function getInput(): string
{
	if ($_POST['input']) {
		$input = json_decode($_POST['input']);
	} else {
		$input = '';
	}

	return $input;
}
