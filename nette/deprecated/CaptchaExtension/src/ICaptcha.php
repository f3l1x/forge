<?php

interface ICaptcha
{

    function getControl();

    function validate($hash, $responce);

    function getErrors();

    function hasErrors();

    function addError($error);
}