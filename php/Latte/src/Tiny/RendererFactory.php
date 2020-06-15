<?php declare(strict_types = 1);

namespace Tlapnet\Forge\Latte\Tiny;

use Latte\Loaders\StringLoader;

final class RendererFactory
{

	/** @var string */
	private $tempPath;

	/** @var bool */
	private $strictMode;

	public function __construct(string $tempPath, bool $strictMode = true)
	{
		$this->tempPath = $tempPath;
		$this->strictMode = $strictMode;
	}

	public function create(): Renderer
	{
		$engine = new TinyLatteEngine();
		$engine->setStrictMode($this->strictMode);
		$engine->setTempDirectory($this->tempPath);
		$engine->setLoader(new StringLoader());
		$engine->setAutoRefresh(false);

		return new Renderer($engine);
	}

}
