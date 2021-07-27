<?php

namespace Minetro\Micro\Routing;

use Nette\Application\IRouter;
use Nette\Application\Routers\RouteList;

/**
 * Abstract routes provider.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class RouterManager
{

    /** @var IRoutesProvider[] */
    private $providers = [];

    /**
     * @param IRoutesProvider $provider
     */
    public function addProvider(IRoutesProvider $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * @param RouteList $router
     * @return IRouter $router
     */
    public function create(RouteList $router)
    {
        foreach ($this->providers as $provider) {
            $provider->createRoutes($router);
        }

        return $router;
    }
}