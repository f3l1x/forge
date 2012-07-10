## EmailProtection

Small Latte helper based on Smarty idea for protect your email address.


Presenter
===========


	public function beforeRender(){
		$this->template->registerHelper('email', 'EmailProtection::helper');	
	}



Latte
========

	{var $mail = "my@email.net"}
	
	{!$mail|email:"javascript"}
	{!$mail|email:"javascript_charcode"}
	{!$mail|email:"hex"}
	{!$mail|email:"javascript":"link to my email here"}
	{!$mail|email:"drupal"}
	{!$mail|email:"texy"}

* '!' is necessary for not escaping html/javascript code

