<?php
class MyPresenter{
	
	protected function createComponentForm(){
		$form = new Form;
		
		$form->addText('title','Titulek', 80)
			->addRule(Form::FILLED, 'Vyplňte prosím titulek!');
		$form->addTextarea('text','Text', 50, 20)
			->addRule(Form::FILLED, 'Vyplňte prosím text článku!')
			->getControlPrototype()->setClass('wysiwyg');
		
		$form->addSubmit('ok','Upravit')->getControlPrototype()->data['confirm'] = "Opravdu chcete upravit tento clanek?";
		$form->onSuccess[] = callback($this, 'process');
		
		return $form;
	}	
	
}