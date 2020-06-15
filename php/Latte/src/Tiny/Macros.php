<?php declare(strict_types = 1);

namespace Tlapnet\Forge\Latte\Tiny;

use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;

final class Macros extends MacroSet
{

	private const DEFAULT_FILTER = '|escape';

	public static function register(Compiler $compiler): void
	{
		$me = new static($compiler);

		$me->addMacro('=', [$me, 'macroExpr']);
	}

	public function macroExpr(MacroNode $node, PhpWriter $writer): string
	{
		$this->validateArgs($node);
		$this->removeFilters($node);

		return $writer->write($node->name === '='
			? 'echo %modify(%node.args) ' . sprintf('/* line %s */', $node->startLine)
			: '%modify(%node.args);');
	}

	private function validateArgs(MacroNode $node): void
	{
		if (substr($node->args, 0, 1) !== '$') {
			throw new TextProcessingRendererException(
				'Trying to call some code. Only printing variables is allowed. Use $variable'
			);
		}
	}

	private function removeFilters(MacroNode $node): void
	{
		$node->modifiers = self::DEFAULT_FILTER;
	}

}
