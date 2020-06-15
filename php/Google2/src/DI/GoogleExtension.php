<?php declare(strict_types = 1);

namespace Contributte\Google\DI;

use Contributte\Google\OAuthClient;
use Contributte\Google\Session;
use Contributte\Google\Sso;
use Contributte\Google\Tracy\GooglePanel;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;

class GoogleExtension extends CompilerExtension
{

	/** @var mixed[] */
	private $defaults = [
		'debug' => FALSE,
		'clientId' => NULL,
		'clientSecret' => NULL,
	];

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		$builder->addDefinition($this->prefix('session'))
			->setFactory(Session::class);

		$builder->addDefinition($this->prefix('oauth'))
			->setFactory(OAuthClient::class)
			->setArguments([
				$config['clientId'],
				$config['clientSecret'],
			]);

		$builder->addDefinition($this->prefix('sso'))
			->setFactory(Sso::class);

		if ($config['debug'] === TRUE) {
			$builder->addDefinition($this->prefix('panel'))
				->setFactory(GooglePanel::class);
		}
	}

	public function afterCompile(ClassType $class): void
	{
		$config = $this->validateConfig($this->defaults);

		if ($config['debug'] === TRUE) {
			$initialize = $class->getMethod('initialize');
			$initialize->addBody('$this->getService(?)->addPanel($this->getService(?));', ['tracy.bar', $this->prefix('panel')]);
		}
	}

}
