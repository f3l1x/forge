<?php
/**
 * Copyright (c) 2013 Milan Felix Sulc <rkfelix@gmail.com>
 */

use Nette\Object;
use Nette\Http\Request;

/**
 * Thumbator factory - creates Thumbator
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.1
 */

final class ThumbatorFactory extends Object implements IThumbatorFactory
{

    /** @var Request */
    private $httpRequest;

    /** @var string */
    private $wwwPath;

    /** @var string */
    private $thumbDir;

    /**
     * @param \Nette\Http\Request $request
     * @param string $wwwPath
     * @param string $thumbDir
     * @return Thumbator
     */
    function __construct(\Nette\Http\Request $request, $wwwPath, $thumbDir = 'temp')
    {
        $this->httpRequest = $request;
        $this->wwwPath = $wwwPath;
        $this->thumbDir = $thumbDir;
    }

    /**
     * @return Thumbator
     */
    public function create()
    {
        $t = new Thumbator($this->httpRequest);
        $t->setWwwPath($this->wwwPath);
        $t->setThumbDir($this->thumbDir);
        return $t;
    }
}