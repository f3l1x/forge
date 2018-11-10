<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


final class FormFactory
{
	use Nette\SmartObject;

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;
		return $form;
	}
}
