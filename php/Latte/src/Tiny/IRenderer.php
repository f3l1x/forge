<?php declare(strict_types = 1);

namespace Tlapnet\Forge\Latte\Tiny;

interface IRenderer
{

	/**
	 * @param mixed[] $params
	 */
	public function render(string $content, array $params = []): string;

}
