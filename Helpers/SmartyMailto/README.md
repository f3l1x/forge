Presenter:

public function beforeRender(){
	$this->template->registerHelper('email', 'SmartyMailto::helper');	
}


---------------------------------------------


Latte:

{var $mail = "my@email.net"}

{!$mail|email:"javascript"}
{!$mail|email:"javascript_charcode"}
{!$mail|email:"hex"}
{!$mail|email:"javascript":"link to my email here"}

'!' is necessary for not escaping html/javascript code

