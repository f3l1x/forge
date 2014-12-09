# EmailProtection

Small Latte helper based on Smarty idea to protect your email address.

## Info

* @version 1.3
* @author Milan Felix Sulc <rkfelix@gmail.com>
* @license MIT

## Template

```php
    function helper($email, $encoding = NULL, $text = NULL)
```

	{var $mail = "my@email.net"}
	
	{!$mail|email:"javascript"}
	{!$mail|email:"javascript_charcode"}
	{!$mail|email:"hex"}
	{!$mail|email:"javascript":"link to my email here"}
	{!$mail|email:"drupal"}
	{!$mail|email:"texy"}

* '!' is necessary for not escaping html/javascript code

