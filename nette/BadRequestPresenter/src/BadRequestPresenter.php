<?php
/**
 * Copyright (c) 2012 Milan Felix Sulc <rkfelix@gmail.com>
 */
use \Nette\Application\UI\Presenter;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 0.1
 */
class BadRequestPresenter extends Presenter
{
    /** @var int */
    private $code;

    /** @var string */
    private $message;

    /**
     * Presenter startup method
     * @override
     * @return void
     */
    public function startup()
    {
        parent::startup();

        // Parse error code
        $this->code = str_replace(array('error', 'e'), NULL, $this->getAction());
        // Parse error message
        $this->message = $this->getParameter('message');
        // Find and throw error
        $this->throwError();
    }

    /**
     * Action delegate XXX errors
     *
     * @throws Nette\Application\BadRequestException
     * @return void
     */
    protected function throwError()
    {
        switch ($this->code) {
            case 403:
                throw new \Nette\Application\BadRequestException($this->getMessage('Access Denied'), 403);
            case 404:
                throw new \Nette\Application\BadRequestException($this->getMessage('Page Not Found'), 404);
            case 405:
                throw new \Nette\Application\BadRequestException($this->getMessage('Method Not Allowed'), 405);
            case 410:
                throw new \Nette\Application\BadRequestException($this->getMessage('Page Not Found'), 410);
            case 500:
                throw new \Nette\Application\BadRequestException($this->getMessage('Server error'), 500);
            default:
                throw new \Nette\InvalidStateException('Undefined error code exception');
        }
    }

    /**
     * Returns error message
     * @param string $default
     * @return string
     */
    protected function getMessage($default)
    {
        if (isset($this->message) || !is_null($this->message)) {
            return $this->message;
        }
        return $default;
    }

}