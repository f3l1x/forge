<?php
require_once('captcha_class.php');
require_once('captcha_http.class.php');
require_once('captcha_xmlrpc.class.php');

class SeznamCaptcha extends NControl implements ICaptcha
{

	public $captcha_hash = 'hash';
	public $captcha_responce = 'code';
	public $captcha = null;
	public $hash = null;
	public $image = null;
	public $errors = array();
	
	public $xmlrpc = false;

	function __construct(){
		parent::__construct();
		
		if($this->xmlrpc){
			$this->captcha = new CaptchaXMLRPC("captcha.seznam.cz", 3410);
			//$this->captcha->setProxy("proxy", 3128);
		}else{
			$this->captcha = new CaptchaHTTP("captcha.seznam.cz", 80);
		}
		
		$this->create();
	}

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
		
		if($this->hasErrors()) return "Nepodarilo se vytvorit captchu.";
		
		$template = $this->template;
		$template->setFile(dirname(__FILE__) . '/SeznamCaptcha.latte');
		$template->captcha_hash = $this->captcha_hash;
		$template->captcha_responce = $this->captcha_responce;
		$template->hash = $this->getHash();
		$template->image = $this->getImage();
		$template->xmlrpc = $this->xmlrpc;

		return $template;
	}
	
	public function getHash(){
		return $this->hash;	
	}

	public function setHash($hash){
		$this->hash = $hash;
		return $this;
	}

	public function getImage(){
		if($this->xmlrpc){
			try {
				$data = $this->captcha->getImage($this->getHash());
				$im = imagecreatefromstring($data);
				$img = new NImage($im);
			}catch (Exception $e) {
				$img = NImage::fromBlank(200, 25, NImage::rgb(255, 255, 255));
				$img->imagestring($img, 3, 0, 0, "Nepodarilo se ziskat obrazek", 1);
				$this->addError($e->__toString());
			}
			
			//$img->send(NImage::GIF);
			return (string) $img;
		}else{
			return $this->image;	
		}
	}

	public function setImage($image){
		$this->image = $image;
		return $this;
	}

	public function create(){
		try {
			$this->setHash($this->captcha->create());
			$this->setImage($this->captcha->getImage($this->getHash()));
		}catch (Exception $e) {
			$this->addError($e->getMessage());
		}	
	}

	public function validate($hash, $responce){

		try {
			$ok = $this->captcha->check($hash, $responce);
		}catch (Exception $e) {
			$this->addError("Nepodarilo se overit captchu!");
			return false;
		}

		if ($ok) {
			return true;
		} else {
			$this->addError("Kody se neshoduji.");
			return false;
		}		
	}

}
