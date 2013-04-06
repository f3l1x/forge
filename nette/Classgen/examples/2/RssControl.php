<?php
class RssControl{
	
	/* variables */
	public $title;
	public $author;
	public $date;
	public $message;
	public $category;
	
	/* setters */
	public function setTitle($title){
		$this->title = $title;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function setDate($date){
		$this->date = $date;
	}

	public function setMessage($message){
		$this->message = $message;
	}

	public function setCategory($category){
		$this->category = $category;
	}

	/* getters */
	public function getTitle($title){
		return $this->title;
	}

	public function getAuthor($author){
		return $this->author;
	}

	public function getDate($date){
		return $this->date;
	}

	public function getMessage($message){
		return $this->message;
	}

	public function getCategory($category){
		return $this->category;
	}

	/* functions */
	public function render(){
	}

}
