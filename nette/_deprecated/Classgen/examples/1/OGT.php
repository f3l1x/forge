<?php
class FbTools2_OpenGraphTags extends NControl implements IFbTools, Itest{
	
	/* variables */
	public $aho2j;
	private $url;
	public $height = 88;
	public $ahoj = 'moje';
	
	/* setters */
	private function setUrl($url){
		$this->url = $url;
	}

	public function setAhoj($ahoj){
		$this->ahoj = $ahoj;
	}

	/* getters */
	public function getAhoj($ahoj){
		return $this->ahoj;
	}

	/* functions */
	public function render($par1 = '1231a', $par2, $test = 1){
	}

	public function renderMin(){
	}

}
