<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Latte\Helpers;

use NettePlugins\Latte\Helpers\Email\EmailHelper;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */
class Helpers
{

    /**
     * @param string $email
     * @param string $encode
     * @param string $text
     * @return string
     */
    public static function email($email, $encode = NULL, $text = NULL)
    {
        return EmailHelper::mailto($email, $encode, $text);
    }
}