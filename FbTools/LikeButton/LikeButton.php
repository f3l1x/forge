<?php
/**
 * LikeButton control
 *
 * @package #FbTools
 * @copyright Milan Felix Sulx
 * @licence WTFPL - Do What The Fuck You Want To Public License 
 * @version 1.0
 */
 
/**
Facebook Attributes
    href - the URL to like. The XFBML version defaults to the current page.
    layout - there are three options.
        standard - displays social text to the right of the button and friends' profile photos below. Minimum width: 225 pixels. Default width: 450 pixels. Height: 35 pixels (without photos) or 80 pixels (with photos).
        button_count - displays the total number of likes to the right of the button. Minimum width: 90 pixels. Default width: 90 pixels. Height: 20 pixels.
        box_count - displays the total number of likes above the button. Minimum width: 55 pixels. Default width: 55 pixels. Height: 65 pixels.
    show_faces - specifies whether to display profile photos below the button (standard layout only)
    width - the width of the Like button.
    action - the verb to display on the button. Options: 'like', 'recommend'
    font - the font to display in the button. Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
    colorscheme - the color scheme for the like button. Options: 'light', 'dark'
    ref - a label for tracking referrals; must be less than 50 characters and can contain alphanumeric characters and some punctuation (currently +/=-.:_). The ref attribute causes two parameters to be added to the referrer URL when a user clicks a link from a stream story about a Like action:
        fb_ref - the ref parameter
        fb_source - the stream type ('home', 'profile', 'search', 'other') in which the click occurred and the story type ('oneline' or 'multiline'), concatenated with an underscore.

 */
class FbTools_LikeButton extends NControl
{
	// like url
	public $url = "http://www.facebook.com/netteframework";
	
	// auto get url
	public $autoUrl = false;
	
	/*
	 * 1,standard 				= standard
	 * 2,button,button_count 	= button_count
	 * 3,box,box_count			= box_count
	 */
	public $layout = "standard";
	
	// box width
	public $width = 450;
	
	// box height
	public $height = 80;
	
	/*
	 * verb to display
	 * 1,like       	= like
	 * 2,recommended	= recommended
	 */
	public $type = "like";
	
	// true/false
	public $showFaces = false;
	
	/* 
	 * text font
	 * arial, lucida grande, segoe ui, tahoma, trebuchet ms, verdana
	 */ 
    public $font = "arial";

	// colorScheme
	// light/dark
	public $colorScheme = "light";
	
	// xfbml (future)
	public $xfbml = false;
	
	// copyright
	public $copyright = true;
	

	/*
	 * Setters
	 */
	public function setUrl($url){
		$this->url = $url;
	}
	
	public function setLayout($layout){
		if($layout == 2 || $layout == "button" || $layout == "button_count"){
			$this->layout = "button_count";
		}else if($layout == 3 || $layout == "box" || $layout == "box_count"){
			$this->layout = "box_count";
		}else{
			$this->layout = "standard";
		}
	}

	public function setWidth($width){
		$this->width = (int) $width;
	}

	public function setHeight($height){
		$this->height = (int) $height;
	}
		
	public function setType($type){
		if($type == 2 || $type == "recommended"){
			$this->type = "recommended";
		}else{
			$this->type = "like";
		}		
	}
	
	public function setShowFaces($showFaces){
		$this->showFaces = $showFaces;
	}

	public function setFont($font){
		switch($font){
			case "lucida grande":
				$this->font = "arial";break;
			case "segoe ui":
				$this->font = "segoe ui";break;
			case "tahoma":
				$this->font = "tahoma";break;
			case "trebuchet ms":
				$this->font = "trebuchet ms";break;
			case "verdana":
				$this->font = "verdana";break;
			default: $this->font = "arial";
		}
	}

	public function setColorScheme($scheme){
		$this->colorScheme = $scheme;	
	}
	
	public function setXfbml($xfbml){
		$this->xfbml = $xfbml;	
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

	public function getLayout(){
		return $this->layout;	
	}
	
	public function getWidth(){
		return (int) $this->width;	
	}

	public function getHeight(){
		return (int) $this->height;	
	}
	
	public function getType(){
		return $this->type;	
	}

	public function getShowFaces($boolean = false){
		if($boolean)
			return ($this->showFaces == 1 ? "true" : "false");
		else return (int) $this->showFaces;	
	}		
	
	public function getFont(){
		return $this->font;
	}
	
	public function getColorScheme(){
		return $this->colorScheme;	
	}
	
	public function isXfbml(){
		return $this->xfbml;	
	}

	public function isAutoUrl(){
		return $this->autoUrl;	
	}
	
	public function writeCopyrightTags(){
		return $this->copyright;	
	}

	/*
	 * Renders
	 */
	public function render($args = array()){
		$this->parseParams($args);
		$this->generate();	
	}
	
	public function renderFaces($args = array()){
		$this->parseParams($args);
		$this->setLayout(1); // showFaces funguje jen s layoutem 1(standard)
		$this->setShowFaces(true);	
		$this->generate();	
	}
	
	public function renderButton($args = array()){
		$this->parseParams($args);
		$this->setLayout(2);	
		$this->generate();	
	}

	public function renderBox($args = array()){
		$this->parseParams($args);
		$this->setLayout(3);	
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
		if(array_key_exists('height', $params))
			$this->setHeight($params['height']);	
		// set up layout
		if(array_key_exists('layout', $params))
			$this->setLayout($params['layout']);	
		// set up type
		if(array_key_exists('type', $params))
			$this->setType($params['type']);	
		// set up font
		if(array_key_exists('font', $params))
			$this->setFont($params['font']);	
		// set up colorscheme
		if(array_key_exists('scheme', $params))
			$this->setColorScheme($params['scheme']);	
		// set up show_faces
		if(array_key_exists('faces', $params))
			$this->setShowFaces($params['faces']);		
	}

	/*
	 * Generating
	 */
	public function generate(){

		// inic
		$output = null;

		// settings
		$settings = array(
			'href' => $this->getUrl(),
			'layout' => $this->getLayout(),
			'show_faces' => $this->getShowFaces(true),
			'width' => $this->getWidth(),
			'action' => $this->getType(),
			'font' => $this->getFont(),
			'colorscheme' => $this->getColorScheme(),
			'height' => $this->getHeight());
			
		$query = http_build_query($settings, '', '&');
		
		// start tag
		if($this->writeCopyrightTags()) $output .= "<!-- @FbTools: LikeButton --!>\n";
		
		// iframe tag
		$el = NHtml::el("iframe");
		$el->src = "http://www.facebook.com/plugins/like.php?" . $query;
		$el->scrolling = "no";
		$el->frameborder = 0;
		$el->allowTransparency = "true";
			$el->style['border'] = "none";
			$el->style['overflow'] = "hidden";
			$el->style['width'] = $this->getWidth() . "px";
			$el->style['height'] = $this->getHeight() . "px";
		
		$output .= $el;
		
		// end tag
		if($this->writeCopyrightTags()) $output .= "\n<!-- /@FbTools: LikeButton --!>\n";
		
		echo $output;
	}
}