<?php
class CaptchaBase{
	
	public static $error_msg = "Captcha byla špatně vyplněna, zkuste to prosím znovu.";
	public static $extension = null;

	public function captcha(NForm $form, $name, $label = NULL){
		$control = $form[$name] = new CaptchaField($label);
		$control->setExtension(self::getExtension());
		$control->addRule('CaptchaField::validateValid', self::getErrorMsg());
		
		return $control;
	}
	
	public function setErrorMsg($msg){
		self::$error_msg = $msg;
		return $this;	
	}

	public static function getErrorMsg(){
		return self::$error_msg;
	}

	public function setExtension($ext){
		self::$extension = $ext;
		return $this;	
	}

	public static function getExtension(){
		return self::$extension;
	}
	
}

