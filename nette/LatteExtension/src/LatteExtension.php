<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\LatteExtension;

use Nette\DI\CompilerExtension;

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