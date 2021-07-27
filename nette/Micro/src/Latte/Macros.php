<?php

namespace Minetro\Micro\Latte;

use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;

/**
 * Micro macros.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Macros extends MacroSet
{
    /**
     * @param Compiler $compiler
     */
    public static function install(Compiler $compiler)
    {
        $me = new static($compiler);
        $me->addMacro('url', [$me, 'macroUrl']);
        $me->addMacro('link', [$me, 'macroLink']);;
        $me->addMacro('mlink', [$me, 'macroMlink']);
    }

    /**
     * @param MacroNode $node
     * @param PhpWriter $writer
     */
    public function macroUrl(MacroNode $node, PhpWriter $writer)
    {
        return $writer->write('echo %escape(%modify($template->basePath . "/" . %node.word))');
    }

    /**
     * @param MacroNode $node
     * @param PhpWriter $writer
     */
    public function macroLink(MacroNode $node, PhpWriter $writer)
    {
        return $writer->write('echo %escape(%modify($template->_presenter->link(%node.word, %node.array?)))');
    }

    /**
     * @param MacroNode $node
     * @param PhpWriter $writer
     */
    public function macroMlink(MacroNode $node, PhpWriter $writer)
    {
        return $writer->write('echo %escape(%modify($template->_presenter->link("Micro:Website:Page:", %node.array?)))');
    }

}
