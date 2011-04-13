<?php

class CaptchaField extends NTextBase {
	
	public $captcha_element = 'div';
	public $extension;
	public $hash = null;
	public $responce = null;
	public $error = null;
	
	public function __construct($label = NULL)
	{
		parent::__construct($label);
		$this->control = NHtml::el($this->captcha_element);
	}	
	
	public function getLabel($label = NULL)
	{
		return NULL;
	}
	
	public function getControl($label = NULL)
	{
		return parent::getControl();
	}
		
	public static function addCaptcha(NForm $form, $name, $label = NULL)
	{
		return $form[$name] = new self($label);
	}

	public function loadHttpData()
	{
		$this->hash = NArrayTools::get($this->getForm()->getHttpData(), $this->getExtension()->captcha_hash);
		$this->responce = NArrayTools::get($this->getForm()->getHttpData(), $this->getExtension()->captcha_responce);
		$this->setValue($this->responce);
	}
	
	public static function validateValid(IFormControl $control)
	{
		$res = $control->getExtension()->validate($control->hash, $control->responce);
		if($res){
			return true;
		}else{
			$control->error = $control->getExtension()->getError();
			return false;
		}
	}
	
	public function setExtension(ICaptcha $ext){
		$this->extension = $ext;
		$this->control->setHtml($ext->getControl());
		return $this;
	}
	
	public function getExtension(){
		return $this->extension;	
	}
}
