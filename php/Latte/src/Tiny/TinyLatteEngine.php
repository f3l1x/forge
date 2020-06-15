<?php declare(strict_types = 1);

namespace Tlapnet\Forge\Latte\Tiny;

use Latte\CompileException;
use Latte\Compiler;
use Latte\Engine;
use Latte\Token;

final class TinyLatteEngine extends Engine
{

	private const DEFAULT_VALUE = '';

	/** @var Compiler|null */
	private $customCompiler;

	/** @var bool */
	private $strictMode = true;

	/**
	 * Overrides the default getCompiler method
	 * Creates new compiler without standard filters and macros
	 */
	public function getCompiler(): Compiler
	{
		if ($this->customCompiler === null) {
			$this->customCompiler = new Compiler();
			Macros::register($this->customCompiler);
		}

		return $this->customCompiler;
	}

	/**
	 * @param mixed $content
	 * @param mixed[] $params
	 * @param mixed $block
	 * @throws CompileException
	 */
	public function renderToString($content, array $params = [], $block = null): string
	{
		if (!$this->strictMode) {
			// Fill missing parameters with default values not to raise possible exceptions
			$tokens = $this->getParser()->parse($content);
			$params = $this->getCompleteParamsList($tokens, $params);
		}

		return parent::renderToString($content, $params, $block);
	}

	/**
	 * @param Token[] $tokens
	 * @param mixed[] $params
	 * @return mixed[]
	 */
	private function getCompleteParamsList(array $tokens, array $params): array
	{
		foreach ($tokens as $token) {
			if ($token->type !== 'macroTag') {
				continue;
			}

			$paramName = substr($token->value, 1); // remove "$" from string start

			if (array_key_exists($paramName, $params)) {
				continue;
			}

			$params[$paramName] = self::DEFAULT_VALUE;
		}

		return $params;
	}

	public function setStrictMode(bool $strictMode): void
	{
		$this->strictMode = $strictMode;
	}

	public function isStrictMode(): bool
	{
		return $this->strictMode;
	}

}
