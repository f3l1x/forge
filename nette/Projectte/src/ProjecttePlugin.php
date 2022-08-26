<?php

namespace Projectte;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\Link;
use Composer\Package\Version\VersionParser;
use Composer\Plugin\PluginInterface;

echo 'Plugin Loaded ' . \PHP_EOL;

class ProjecttePlugin implements PluginInterface
{
	protected $composer;
	protected $io;

	public function activate(Composer $composer, IOInterface $io)
	{
		echo 'Activate event ' . \PHP_EOL;
		$this->composer = $composer;
		$this->io = $io;

		$versionParser = new VersionParser();

		$requires = array_merge(
			$composer->getPackage()->getRequires(),
			['nette/utils' => new Link('__root__', 'nette/utils', $versionParser->parseConstraints('~2.4.8'), 'requires')]
		);

		$composer->getPackage()->setRequires($requires);
	}
}