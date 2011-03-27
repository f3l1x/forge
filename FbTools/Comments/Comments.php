<?php
/**
 * Comments control
 *
 * @package #FbTools
 * @copyright Milan Felix Sulx
 * @licence WTFPL - Do What The Fuck You Want To Public License 
 * @version 1.0
 */

/**
Facebook Attributes
    href - the URL for this Comments plugin. News feed stories on Facebook will link to this URL.
    width - the width of the plugin in pixels. Minimum width: 350px.
    num_posts - the number of comments to show by default. Default: 10.
*/

class FbTools_Comments extends NControl
{
	// comment url
	public $url = "http://nette.org/";
	
	// auto get url
	public $autoUrl = false;
	
	// box width
	public $width = 450;
	
	// number of posts
	public $numPosts = 10;
	
	// copyright
	public $copyright = true;
	
	/*
	 * Setters
	 */
	public function setUrl($url){
		$this->url = $url;
	}
	
	public function setWidth($width){
		$this->width = (int) $width;
	}

	public function setNumPosts($posts){
		$this->numPosts = (int) $posts;
	}

	public function setAutoUrl($autoUrl){
		$this->autoUrl = $autoUrl;	
	}
	
	public function setCopyright($copyright){
		$this->copyright = $copyright;	
	}

	/*
	 *Getters
	 */
		
	public function getUrl(){
		if($this->isAutoUrl()){
			return (string) NEnvironment::getHttpRequest()->getUri();	
		}else{
			return $this->url;	
		}
	}

	public function getWidth(){
		return (int) $this->width;	
	}

	public function getNumPosts(){
		return (int) $this->numPosts;	
	}
	
	public function isAutoUrl(){
		return $this->autoUrl;	
	}
	
	public function writeCopyrightTags(){
		return $this->copyright;	
	}

	/*
	 * Render
	 */
	public function render($args = array()){
		$this->parseParams($args);
		$this->generate();	
	}
		
	/* parse control config from template */
	public function parseParams($params = array()){
		// set up url
		if(array_key_exists('url', $params))
			$this->setUrl($params['url']);	
		// set up width
		if(array_key_exists('width', $params))
			$this->setWidth($params['width']);	
		// set up height
		if(array_key_exists('posts', $params))
			$this->setNumPosts($params['posts']);	
	}

	/*
	 * Generating
	 */
	public function generate(){
		
		// inic
		$output = null;
		
		// start tag
		if($this->writeCopyrightTags()) $output .= "<!-- @FbTools: Comments --!>\n";

		// div tag
		$div = NHtml::el("div");
		$div->id = "fb-root";     
		$output .= $div;
        
		// script tag
		$script = NHtml::el("script");
		$script->src = "http://connect.facebook.net/en_US/all.js#appId=186670371343644&xfbml=1";     
		$output .= $script;		
		
		// facebook tag
		$fb = NHtml::el("fb:comments");
		$fb->href = $this->getUrl();
		$fb->num_posts = $this->getNumPosts();
		$fb->width = $this->getWidth();
		$output .= $fb;		
		
		// end tag
		if($this->writeCopyrightTags()) $output .= "\n<!-- /@FbTools: Comments --!>\n";
		
		echo $output;
	}
}