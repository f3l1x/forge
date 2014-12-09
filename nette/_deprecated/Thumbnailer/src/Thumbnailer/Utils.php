<?php
/**
 * Copyright (c) 2012 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Thumbnailer;

use Nette\Utils\Strings;

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */
class Utils extends Strings
{

    /**
     * Join and transfer more / to only 1
     *
     * @static
     * @return array|mixed|string
     */
    public static function dirs(/** $dir1, $dir2, .. */)
    {
        $dirs = func_get_args();

        // join to 1 dir
        $dirs = implode('/', $dirs);

        // replace dopple / to only 1
        $dirs = preg_replace('#[\/]{2,}#', '/', $dirs);

        // replace table
        $dirs = str_replace(array('./'), array(''), $dirs);

        return $dirs;
    }

    /**
     * Gets file extension
     *
     * @static
     * @param $str
     * @return string
     */
    public static function ext($str)
    {
        return self::lower(substr($str, strripos($str, '.') + 1));
    }

    /**
     * Returns the sanitized file name.
     *
     * @static
     * @param $name
     * @return string
     */
    public static function sanitized($name)
    {
        return trim(self::webalize($name, '.', FALSE), '.-');
    }
}