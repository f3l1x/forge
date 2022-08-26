<?php

namespace Contributte\Advisories\DI;

use Contributte\Advisories\Tracy\SuggestionBlueScreen;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Nette\InvalidStateException;
use Nette\PhpGenerator\ClassType;
use Tracy\Debugger;

final class AdvisoriesExtension extends CompilerExtension
{

	/**
	 * Update initialize
	 *
	 * @param ClassType $class
	 */
	public function afterCompile(ClassType $class)
	{
		$initialize = $class->getMethod('initialize');
		$builder = $this->getContainerBuilder();

		if (!class_exists(Debugger::class)) {
			throw new InvalidStateException('Tracy is required, please install her.');
		}

		$initialize->addBody($builder->formatPhp('?;', [
			new Statement('@Tracy\BlueScreen::addPanel', [new Statement(SuggestionBlueScreen::class)]),
		]));
	}

}
