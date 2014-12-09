<?php

use Nette\Application\UI\Presenter;
use Nette\DI\Container;
use Tracy\Debugger;

class SignPresenter extends Presenter
{

    /**
     * @cron
     */
    public function test1(Container $container, $params = NULL)
    {
        Debugger::dump($params);
    }


    /**
     * @cron
     * @days(0,2,4,6)
     * @hours(0, 4)
     * @minutes (15, 30, 45)
     */
    public function test2(Container $container, $params = NULL)
    {
        Debugger::dump($params);
    }
}
