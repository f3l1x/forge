<?php
require_once('recaptchalib.php');

class reCaptcha extends NControl implements ICaptcha
{

	public $publickey = "";
	public $privatekey = "";
	public $captcha_hash = 'recaptcha_challenge_field';
	public $captcha_responce = 'recaptcha_response_field';

	# the response from reCAPTCHA
	public $resp = null;
	# the error code from reCAPTCHA, if any
	public $error = null;

	public function getError(){
		return $this->error;	
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
			$this->error = $resp->error;
			return false;
		}		
	}

}
