<?php
/**
 * Copyright (c) 2013 Milan Felix Sulc <rkfelix@gmail.com>
 */

use Nette\Object;

/**
 * Thumbator factory interface
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */

interface IThumbatorFactory
{

    /**
     * @return Thumbator
     */
    function create();
}