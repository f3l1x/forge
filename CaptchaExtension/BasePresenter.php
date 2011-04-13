<?php
abstract class BasePresenter extends NPresenter
{

	public function createComponentForm(){
				
		$captcha = new reCaptcha();
		NFormContainer::extensionMethod('addCaptcha', array('CaptchaField', 'addCaptcha'));

		$form = new NAppForm();
		$form->addCaptcha('captcha')->setExtension($captcha)->addRule('CaptchaField::validateValid', 'Spatne vyplneny kod.');
		$form->addText('text','Nejaky textik');
		$form->addSubmit('ok', 'odeslat');
		
		$form->onSubmit[] = array($this, 'captchaProcess');
		return $form;
	}
	
	public function captchaProcess(NAppForm $form){
		// vypise chyby z komponenty..
		if(!empty($form['captcha']->errors)){
			echo "Chyby z CaptchaField:<br>";
			var_dump($form['captcha']->errors);	
		}
		
		if($form->isSubmitted() && $form->isValid()){
			echo "Formular se povedlo odeslat:<br>";
			var_dump($form->values);
		}
	}
}
