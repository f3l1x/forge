<?php
/**
 * Copyright (c) 2013 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Thumbator;

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