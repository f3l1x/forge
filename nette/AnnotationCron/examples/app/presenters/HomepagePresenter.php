<?php

/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

    /**
     * @cron
     */
    public function homepage() {
        \Nette\Diagnostics\Debugger::dump('homepage');
    }

}
