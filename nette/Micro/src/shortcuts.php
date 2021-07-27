<?php

use Tracy\Debugger;

/**
 * Dump;
 */
function d()
{
    foreach (func_get_args() as $var) {
        dump($var);
    }
}

/**
 * Dump; die;
 */
function dd()
{
    foreach (func_get_args() as $var) {
        dump($var);
    }
    die;
}