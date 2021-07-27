<?php

namespace Minetro\Micro\Debug;

use Exception;
use Nette\Application\Application;
use Nette\Application\IResponse;
use Nette\Application\Request;
use Nette\DI\Container;
use Tracy\Debugger;

/**
 * Application debug helper.
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class ApplicationDebug
{

    /** @var Container */
    private $context;

    /**
     * @param Container $context
     */
    function __construct(Container $context)
    {
        $this->context = $context;

        /** @var Application $app */
        $app = $context->getService('application');
        $app->onStartup[] = [$this, 'doOnStartup'];
        $app->onShutdown[] = [$this, 'doOnShutdown'];
        $app->onRequest[] = [$this, 'doOnRequest'];
        $app->onResponse[] = [$this, 'doOnResponse'];
        $app->onError[] = [$this, 'doOnError'];
    }

    /**
     * @param Application $application
     */
    public function doOnStartup(Application $application)
    {
    }

    /**
     * @param Application $application
     * @param Exception $e
     */
    public function doOnShutdown(Application $application, Exception $e = NULL)
    {
    }

    /**
     * @param Application $application
     * @param Request $request
     */
    public function doOnRequest(Application $application, Request $request)
    {
    }

    /**
     * @param Application $application
     * @param IResponse $response
     */
    public function doOnResponse(Application $application, IResponse $response)
    {
    }

    /**
     * @param Application $application
     * @param Exception $e
     */
    public function doOnError(Application $application, Exception $e)
    {
        Debugger::getBlueScreen()->render($e);
        die();
    }

}