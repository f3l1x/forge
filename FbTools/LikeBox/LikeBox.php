<?php
/**
 * LikeBox control
 *
 * @package #FbTools
 * @copyright Milan Felix Sulx
 * @licence WTFPL - Do What The Fuck You Want To Public License 
 * @version 1.1
 */
 
/**
Facebook Attributes
    href - the URL of the Facebook Page for this Like Box
    width - the width of the plugin in pixels. Default width: 300px.
    height - the height of the plugin in pixels. The default height varies based on number of faces to display, and whether the stream is displayed. With the stream displayed, and 10 faces the default height is 556px. With no faces, and no stream the default height is 63px.
    colorscheme - the color scheme for the plugin. Options: 'light', 'dark'
    show_faces - specifies whether or not to display profile photos in the plugin. Default value: true.
    stream - specifies whether to display a stream of the latest posts from the Page's wall
    header - specifies whether to display the Facebook header at the top of the plugin.

 */
class FbTools_LikeBox extends NControl implements IFbTools
{
	// like url
	public $url = null;

	// box width
	public $width = 292;
	
	// box height
	public $height = 63;
	
	// colorScheme
	public $colorScheme = "light";	
	
	// showFaces
	public $showFaces = false;

	// showStream
	public $showStream = false;

	// showHeader
	public $showHeader = false;
	
	// copyright
	public $copyright = true;
	

	/*
	 * Setters
	 */
	public function setUrl($url){
		$this->url = $url;
		return $this; //fluent interface
	}
	
	public function setWidth($width){
		$this->width = (int) $width;
		return $this; //fluent interface
	}

	public function setHeight($height){
		$this->height = (int) $height;
		return $this; //fluent interface
	}

	public function setColorScheme($scheme){
		$this->colorScheme = $scheme;	
		return $this; //fluent interface
	}

	public function setShowFaces($showFaces){
		$this->showFaces = $showFaces;
		return $this; //fluent interface
	}

	public function setShowStream($showStream){
		$this->showStream = $showStream;
		return $this; //fluent interface
	}

	public function setShowHeader($showHeader){
		$this->showHeader = $showHeader;
		return $this; //fluent interface
	}
	
	public function setCopyright($copyright){
		$this->copyright = $copyright;	
		return $this; //fluent interface
	}
	
	/*
	 *Getters
	 */
		
	public function getUrl(){
		return $this->url;	
	}
		
	public function getWidth(){
		return (int) $this->width;	
	}

	public function getHeight(){
		if((int) $this->height == 0) $this->autoHeight();
		return (int) $this->height;	
	}
	
	public function getColorScheme(){
		return $this->colorScheme;	
	}

	public function getShowFaces(){
		return (int) $this->showFaces;	
	}

	public function getShowHeader(){
		return (int) $this->showHeader;	
	}
	
	public function getShowStream($boolean = false){
		return (int) $this->showStream;	
	}
	
	public function writeCopyrightTags(){
		return $this->copyright;	
	}
	
	public function autoHeight(){
		$height = 62;
		if($this->getShowFaces() == 1) $height += 194;
		if($this->getShowHeader() == 1) $height += 32;
		if($this->getShowStream() == 1) $height += 331;

		$this->setHeight($height);
	}

	/*
	 * Renders
	 */
	public function render($args = array()){
		$this->parseParams($args);
		$this->generate();	
	}
	
	public function renderFull($args = array()){
		$this->parseParams($args);
		$this->setShowFaces(true);
		$this->setShowHeader(true);
		$this->setShowStream(true);
		$this->generate();	
	}
	
	public function renderStream($args = array()){
		$this->parseParams($args);
		$this->setShowStream(true);
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
		// set up colorScheme
		if(array_key_exists('colorScheme', $params))
			$this->setColorScheme($params['colorScheme']);	
		// set up showFaces
		if(array_key_exists('showFaces', $params))
			$this->setShowFaces($params['showFaces']);	
		// set up showHeader
		if(array_key_exists('showHeader', $params))
			$this->setShowHeader($params['showHeader']);	
		// set up showStream
		if(array_key_exists('showStream', $params))
			$this->setShowStream($params['showStream']);		
	}

	/*
	 * Generating
	 */
	public function generate(){

		// inic
		$output = null;

		// settings
		$settings = array();
		$settings['href'] = $this->getUrl();
		$settings['width'] = $this->getWidth();
		$settings['colorscheme'] = $this->getColorScheme();
		$settings['show_faces'] = (bool) $this->getShowFaces();
		$settings['stream'] = (bool) $this->getShowStream();
		$settings['header'] = (bool) $this->getShowHeader();
		$settings['height'] = $this->getHeight();
			
		$query = http_build_query($settings, '', '&');
		
		// start tag
		if($this->writeCopyrightTags()) $output .= "<!-- @FbTools: LikeBox --!>\n";
		
		// iframe tag
		$el = NHtml::el("iframe");
		$el->src = "http://www.facebook.com/plugins/likebox.php?" . $query;
		$el->scrolling = "no";
		$el->frameborder = 0;
		$el->allowTransparency = "true";
			$el->style['border'] = "none";
			$el->style['overflow'] = "hidden";
			$el->style['width'] = $this->getWidth() . "px";
			$el->style['height'] = $this->getHeight() . "px";
		
		$output .= $el;
		
		// end tag
		if($this->writeCopyrightTags()) $output .= "\n<!-- /@FbTools: LikeBox --!>\n";
		
		echo $output;
	}
}