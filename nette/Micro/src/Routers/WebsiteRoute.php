<?php

namespace Minetro\Micro\Modules\Website\Routers;

use Nette;
use Nette\Application;
use Nette\Application\Routers\Route;

/**
 * Website route.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class WebsiteRoute extends Route
{

    /**
     * @param string $mask
     * @param callable $callback
     * @param array $metadata
     * @param int $flags
     */
    public function __construct($mask, \Closure $callback, array $metadata = [], $flags = 0)
    {
        $metadata = array_merge(['presenter' => 'Micro:Website:Page', 'callback' => $callback], $metadata);
        parent::__construct($mask, $metadata, $flags);
    }

    /**
     * @param Application\Request $appRequest
     * @param Nette\Http\Url $refUrl
     * @return NULL|string
     */
    public function constructUrl(Application\Request $appRequest, Nette\Http\Url $refUrl)
    {
        $parameters = $appRequest->getParameters();

        if (isset($parameters['action']) && ($parameters['action'] == FALSE)) {
            $parameters['action'] = NULL;
        }

        $appRequest->setParameters($parameters);

        return parent::constructUrl($appRequest, $refUrl);
    }

}