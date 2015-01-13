<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Latte\Macros;

use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */
class Macros extends MacroSet
{

    /**
     * @param Compiler $compiler
     */
    public static function install(Compiler $compiler)
    {
        $me = new static($compiler);
        $me->addMacro('ifCurrentIn', [$me, 'macroIfCurrentIn'], [$me, 'macroIfCurrentInEnd']);
    }

    /**
     * @param MacroNode $node
     * @param PhpWriter $writer
     */
    public function macroIfCurrentIn(MacroNode $node, PhpWriter $writer)
    {
        $writer->write('foreach (%node.array as $l) { if ($_presenter->isLinkCurrent($l)) { $_c = true; break; }} if (isset($_c)): ');
    }

    /**
     * @param MacroNode $node
     * @param PhpWriter $writer
     */
    public function macroIfCurrentInEnd(MacroNode $node, PhpWriter $writer)
    {
        $writer->write('endif; unset($_c);');
    }
}