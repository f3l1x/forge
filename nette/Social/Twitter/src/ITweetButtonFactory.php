<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Social\Twitter;

/**
 * Twitter > tweet button factory interface
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */
interface ITweetButtonFactory
{

    /**
     * @return TweetButton
     */
    function create();
}