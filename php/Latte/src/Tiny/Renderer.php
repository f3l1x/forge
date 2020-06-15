<?php declare(strict_types = 1);

namespace Tlapnet\Forge\Latte\Tiny;

use Throwable;

final class Renderer implements IRenderer
{

	/** @var TinyLatteEngine */
	private $latte;

	public function __construct(TinyLatteEngine $latte)
	{
		$this->latte = $latte;
	}

	/**
	 * @param mixed[] $params
	 */
	public function render(string $content, array $params = []): string
	{
		try {
			return $this->latte->renderToString($content, $params);
		} catch (Throwable $e) {
			if ($this->latte->isStrictMode()) {
				throw new TextProcessingRendererException($e->getMessage(), $e->getCode(), $e->getPrevious());
			}

			return $content;
		}
	}

	public function setStrictMode(bool $strictMode): void
	{
		$this->latte->setStrictMode($strictMode);
	}

	public function isStrictMode(): bool
	{
		return $this->latte->isStrictMode();
	}

}
