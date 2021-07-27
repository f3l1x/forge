<?php

namespace Minetro\Micro\Routing;

use Nette\Application\IRouter;

/**
 * Router factory.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
interface IRouterFactory
{

    /**
     * @return IRouter
     */
    function create();
}
