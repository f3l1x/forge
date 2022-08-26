<?php

namespace Contributte\Advisories\Complain\UI;

use ArrayAccess;
use Contributte\Advisories\Exception\ComplainException;

class ComplainContextParameters implements ArrayAccess
{

	/** @var array */
	private $parameters = [];

	/**
	 * @param array $parameters
	 */
	public function __construct(array $parameters)
	{
		$this->parameters = $parameters;
	}

	/**
	 * @param mixed $offset
	 * @return void
	 */
	public function offsetExists($offset)
	{
		throw new ComplainException('Do not use $context->parameters. Inject parameters into presenter via constructor, setter, inject method or @inject.', ComplainException::UI_PRESENTER_CONTAINER);
	}

	/**
	 * @param mixed $offset
	 * @return void
	 */
	public function offsetGet($offset)
	{
		throw new ComplainException('Do not use $context->parameters. Inject parameters into presenter via constructor, setter, inject method or @inject.', ComplainException::UI_PRESENTER_CONTAINER);
	}

	/**
	 * @param mixed $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		throw new ComplainException('Do not use $context->parameters. Inject parameters into presenter via constructor, setter, inject method or @inject.', ComplainException::UI_PRESENTER_CONTAINER);
	}

	/**
	 * @param mixed $offset
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		throw new ComplainException('Do not use $context->parameters. Inject parameters into presenter via constructor, setter, inject method or @inject.', ComplainException::UI_PRESENTER_CONTAINER);
	}

}
