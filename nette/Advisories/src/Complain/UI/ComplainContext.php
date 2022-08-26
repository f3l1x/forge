<?php

namespace Contributte\Advisories\Complain\UI;

use Contributte\Advisories\Exception\ComplainException;
use Nette\DI\Container;

class ComplainContext extends Container
{

	/** @var Container */
	private $inner;

	/**
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		parent::__construct();
		$this->inner = $container;
		$this->parameters = new ComplainContextParameters($container->getParameters());
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function getService($name)
	{
		throw new ComplainException('Do not use $context->getService() in presenter. Inject dependencies via constructor, inject method or @inject.', ComplainException::UI_PRESENTER_CONTAINER);
	}

	/**
	 * @param string $type
	 * @param bool $throw
	 * @return void
	 */
	public function getByType($type, $throw = TRUE)
	{
		throw new ComplainException('Do not use $context->getByType() in presenter. Inject dependencies via constructor, inject method or @inject.', ComplainException::UI_PRESENTER_CONTAINER);
	}

}
