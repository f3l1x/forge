<?php
require_once('recaptchalib.php');

class reCaptcha extends NControl implements ICaptcha
{

	public $publickey = "";
	public $privatekey = ""
	public $captcha_hash = 'recaptcha_challenge_field';
	public $captcha_responce = 'recaptcha_response_field';

	# the error code from reCAPTCHA, if any
	public $errors = array();

	public function hasErrors(){
		return (bool) (count($this->getErrors()) > 0); 
	}

	public function getErrors(){
		return (array) $this->errors;	
	}

	public function addError($error){
		$this->errors[] = $error;	
	}

	public function getControl(){
		return recaptcha_get_html($this->publickey, $this->error);
	}

	public function validate($hash, $responce){
		$resp = recaptcha_check_answer (
			$this->privatekey, 
			$_SERVER["REMOTE_ADDR"],
			$hash,
			$responce);
		
		if ($resp->is_valid) {
			return true;
		} else {
		# set the error code so that we can display it
			$this->addError($resp->error);
			return false;
		}		
	}

}
