<?php

namespace Contributte\Advisories\Spy\Presenter;

use Contributte\Advisories\Complain\UI\ComplainContext;
use Nette\Application\IPresenterFactory;
use Nette\Application\IRouter;
use Nette\Application\UI\ITemplateFactory;
use Nette\DI\Container;
use Nette\Http\IRequest;
use Nette\Http\IResponse;
use Nette\Http\Session;
use Nette\Security\User;

trait TPresenterContextSpy
{

	/**
	 * @param Container|NULL $context
	 * @param IPresenterFactory|NULL $presenterFactory
	 * @param IRouter|NULL $router
	 * @param IRequest $httpRequest
	 * @param IResponse $httpResponse
	 * @param Session|NULL $session
	 * @param User|NULL $user
	 * @param ITemplateFactory|NULL $templateFactory
	 */
	public function injectPrimary(
		Container $context = NULL,
		IPresenterFactory $presenterFactory = NULL,
		IRouter $router = NULL,
		IRequest $httpRequest,
		IResponse $httpResponse,
		Session $session = NULL,
		User $user = NULL,
		ITemplateFactory $templateFactory = NULL)
	{
		parent::injectPrimary(new ComplainContext($context), $presenterFactory, $router, $httpRequest, $httpResponse, $session, $user, $templateFactory);
	}

}

