<?php

namespace Tests\Fixtures;

use Contributte\Advisories\Presenter\TPContainerAdvisory;
use Nette\Application\UI\Presenter;

final class PresenterContainer extends Presenter
{

	use TPContainerAdvisory;

	/**
	 * @return void
	 */
	public function actionParameter()
	{
		$this->context->parameters['foo'];
	}

	/**
	 * @return void
	 */
	public function actionGetService()
	{
		$this->context->getService('foo');
	}

	/**
	 * @return void
	 */
	public function actionGetByType()
	{
		$this->context->getByType('foo');
	}

}
