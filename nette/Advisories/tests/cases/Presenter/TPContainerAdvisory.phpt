<?php

/**
 * Test: Presenter\TPContainerAdvisory
 */

require_once __DIR__ . '/../../bootstrap.php';

use Nette\DI\Container;
use Nette\Http\RequestFactory;
use Nette\Http\Response;
use Tester\Assert;
use Tests\Fixtures\PresenterContainer;

// Access parameters
test(function () {
	Assert::error(function () {
		$presenter = new PresenterContainer();
		$presenter->injectPrimary(
			new Container(['foo' => 1]),
			NULL,
			NULL,
			(new RequestFactory())->createHttpRequest(),
			new Response()
		);

		$presenter->actionParameter();
	}, E_USER_WARNING);
});
