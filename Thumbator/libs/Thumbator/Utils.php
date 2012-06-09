<?php

namespace Thumbator;

class Utils extends \Nette\Utils\Strings {

    /**
     * Join and transfer more / to only 1
     *
     * @static
     * @return array|mixed|string
     */
    public static function dirs(/** $dir1, $dir2, .. */) {
        $dirs = func_get_args();
        $dirs = implode('/', $dirs);
        $dirs = preg_replace('#[\/]{2,}#', '/', $dirs);
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
        return self::lower(substr($str, strripos($str, '.')));
    }

    /**
     * Returns the sanitized file name.
     *
     * @static
     * @param $name
     * @return string
     */
    public static function sanitized($name) {
        return trim(self::webalize($name, '.', FALSE), '.-');
    }
}