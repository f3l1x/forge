<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Social\Google;

/**
 * Google +1 component factory interface
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @author Petr Stuchl4n3k Stuchlik <stuchl4n3k@gmail.com>
 * @licence MIT
 * @version 2.0
 */
interface IPlusOneFactory
{

    /**
     * @return PlusOne
     */
    function create();
}