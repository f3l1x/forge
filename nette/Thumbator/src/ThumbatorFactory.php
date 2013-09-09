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
    private $wwwDir;

    /** @var string */
    private $storageDir;

    /** @var string */
    private $thumbDir;

    /**
     * @param \Nette\Http\Request $request
     * @param $wwwDir
     * @param $storageDir
     * @param $thumbDir
     * @return Thumbator
     */
    function __construct(\Nette\Http\Request $request, $wwwDir, $storageDir, $thumbDir)
    {
        $this->httpRequest = $request;
        $this->wwwDir = $wwwDir;
        $this->storageDir = $storageDir;
        $this->thumbDir = $thumbDir;
    }

    /**
     * @return Thumbator
     */
    public function create()
    {
        $t = new Thumbator($this->httpRequest);
        $t->setWwwDir($this->wwwDir);
        $t->setThumbDir($this->thumbDir);
        $t->setStorageDir($this->storageDir);
        return $t;
    }
}