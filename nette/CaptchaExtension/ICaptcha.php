<?php

interface ICaptcha{
	
	function getControl();	
	
	function validate($hash, $responce);	
	
	function getError();
}