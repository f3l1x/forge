<?php

class MyModel extends \Nette\Object
{

    public function __construct(\Nette\Application\Application $presenter)
    {

    }

    /**
     * @cron
     */
    public function methodC()
    {
        \Nette\Diagnostics\Debugger::dump('madafaka');
    }

}