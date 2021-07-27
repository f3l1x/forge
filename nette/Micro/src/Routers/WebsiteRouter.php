<?php

namespace Minetro\Micro\Modules\Website\Routers;

use Minetro\Micro\Modules\Website\Closures\ErrorPageClosure;
use Minetro\Micro\Modules\Website\Closures\StaticPageClosure;
use Minetro\Micro\Routing\AbstractRoutesProvider;
use Nette\Application\BadRequestException;
use Nette\Application\IRouter;

/**
 * Website router.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class WebsiteRouter extends AbstractRoutesProvider
{

    /** @var StaticPageClosure @inject */
    public $staticPageClosure;

    /** @var ErrorPageClosure @inject */
    public $errorPageClosure;

    /**
     * @param IRouter $router
     * @return void
     */
    public function createRoutes(IRouter $router)
    {
        $router[] = new WebsiteRoute(
            // Mask
            '<url .*>/',

            // Closure
            function ($presenter, $url) {
                try {
                    return $this->staticPageClosure->invoke($presenter, $url);
                } catch (BadRequestException $e) {
                    return $this->errorPageClosure->invoke($presenter, $e->getCode());
                }
            },

            // Metadata
            ['url' => 'default']
        );
    }

}
