## SmartyMailto

Small Latte helper based on Smarty idea for protect your email address.


Presenter
===========


	public function beforeRender(){
		$this->template->registerHelper('email', 'SmartyMailto::helper');	
	}



Latte
========

	{var $mail = "my@email.net"}
	
	{!$mail|email:"javascript"}
	{!$mail|email:"javascript_charcode"}
	{!$mail|email:"hex"}
	{!$mail|email:"javascript":"link to my email here"}

<div style="color: red; font-weight: bold;">'!' is necessary for not escaping html/javascript code</div>

