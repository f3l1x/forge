<?php

use Nette\Latte\CompileException;

/**
 * Extension for Latte
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 */
class LatteExtension extends CompilerExtension
{

    public function loadConfiguration()
    {
        $container = $this->getContainerBuilder();
        // Customize latte
        $engine = $container->getDefinition('nette.latte');
        $engine->addSetup('\MyMacros::install(?->compiler)', array('@self'));
    }

}