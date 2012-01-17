<?php

class CaptchaField extends NTextBase {
	
	public $captcha_element = 'div';
	public $extension;
	public $hash = null;
	public $responce = null;
	public $error = null;
	
	public $old_label = true;
	public $show_captcha_error = false;
	
	public function __construct($label = NULL)
	{
		parent::__construct($label);
		$this->control = NHtml::el($this->captcha_element);
	}	
	
	public function getLabel($label = NULL)
	{
		if($this->old_label){
			return parent::getLabel();
		}else{
			return NULL;
		}
	}
	
	public function getControl($label = NULL)
	{
		return parent::getControl();
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
			if($control->show_captcha_error){
				foreach($control->getExtension()->getErrors() as $error){
					$control->addError($error);
				}
			}
			
			$control->error = ($control->getExtension()->getErrors());
			return false;
		}
	}
	
	public function setExtension(ICaptcha $ext){
		$this->extension = $ext;
		$this->control->setHtml($ext->getControl());
		return $this;
	}
	
	public function hasError(){
		if(empty($this->error)){
			return false;
		}else{
			return true;
		}
	}

	public function getError(){
		return $this->error;
	}

	public function getExtension(){
		return $this->extension;	
	}
}