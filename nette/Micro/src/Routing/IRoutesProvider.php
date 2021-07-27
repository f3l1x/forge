<?php

namespace Minetro\Micro\Routing;

use Nette\Application\IRouter;

/**
 * Routes provider interface.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
interface IRoutesProvider
{
    /**
     * @param IRouter $router
     * @return void
     */
    function createRoutes(IRouter $router);

}
