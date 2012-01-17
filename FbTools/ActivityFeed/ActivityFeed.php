<?php
/**
 * AcvitivyFeed control
 *
 * @package #FbTools
 * @copyright Milan Felix Sulx
 * @licence WTFPL - Do What The Fuck You Want To Public License 
 * @version 1.1
 */

/**
Facebook Attributes
    site - the domain to show activity for. The XFBML version defaults to the current domain.
    width - the width of the plugin in pixels. Default width: 300px.
    height - the height of the plugin in pixels. Default height: 300px.
    header - specifies whether to show the Facebook header.
    colorscheme - the color scheme for the plugin. Options: 'light', 'dark'
    font - the font to display in the plugin. Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
    border_color - the border color of the plugin.
    recommendations - specifies whether to always show recommendations in the plugin. If recommendations is set to true, the plugin will display recommendations in the bottom half.
    filter - allows you to filter which URLs are shown in the plugin. The plugin will only include URLs which contain the filter string in the first two path parameters of the URL. If nothing in the first two path parameters of the URL matches the filter, the URL will not be included. For example, if the 'site' parameter is set to 'www.example.com' and the 'filter' parameter was set to '/section1/section2' then only pages which matched 'http://www.example.com/section1/section2/*' would be included in the activity feed section of this plugin. The filter parameter does not apply to any recommendations which may appear in this plugin (see above); Recommendations are based only on 'site' parameter.
    ref - a label for tracking referrals; must be less than 50 characters and can contain alphanumeric characters and some punctuation (currently +/=-.:_). Specifying a value for the ref attribute adds the 'fb_ref' parameter to the any links back to your site which are clicked from within the plugin. Using different values for the ref parameter for different positions and configurations of this plugin within your pages allows you to track which instances are performing the best.
*/

class FbTools_ActivityFeed extends NControl
{
	// activity feed url
	public $url = null;
		
	// box width
	public $width = 300;
	
	// box height
	public $height = 300;

	// show header
	public $showHeader = true;

	// color scheme
	public $colorScheme = "light";

	// font
	public $font = "arial";
	
	// border color
	public $borderColor = null;

	// recommendations
	public $recommendations = 0;
	 
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

	public function setShowHeader($show){
		$this->showHeader = (int) $show;
		return $this; //fluent interface
	}

	public function setColorScheme($colorScheme){
		$this->colorScheme = $colorScheme;
		return $this; //fluent interface
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
		return $this; //fluent interface
	}
	
	public function setBorderColor($borderColor){
		$this->borderColor = $borderColor;
		return $this; //fluent interface
	}	

	public function setRecommendations($rec){
		$this->recommendations = (int) $rec;
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
		return (int) $this->height;	
	}
	
	public function getShowHeader(){
		return (int) $this->showHeader;	
	}

	public function getColorScheme(){
		return $this->colorScheme;	
	}

	public function getFont(){
		return $this->font;	
	}

	public function getBorderColor(){
		return $this->borderColor;	
	}
	
	public function getRecommendations(){
		return (int) $this->recommendations;	
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

	public function renderDark($args = array()){
		$this->parseParams($args);
		$this->setColorScheme("dark");
		$this->generate();	
	}
	
	public function renderLight($args = array()){
		$this->parseParams($args);
		$this->setColorScheme("light");
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
		// set up show header
		if(array_key_exists('showHeader', $params))
			$this->setShowHeader($params['showHeader']);	
		// set up color scheme
		if(array_key_exists('colorScheme', $params))
			$this->setColorScheme($params['colorScheme']);	
		// set up border color
		if(array_key_exists('borderColor', $params))
			$this->setBorderColor($params['borderColor']);	
		// set up height
		if(array_key_exists('recommendations', $params))
			$this->setRecommendations($params['recommendations']);	
	}

	/*
	 * Generating
	 */
	public function generate(){
		
		// inic
		$output = null;

		// settings
		$settings = array(
			'site' => $this->getUrl(),
			'width' => $this->getWidth(),
			'height' => $this->getHeight(),
			'header' => (bool) $this->getShowHeader(),
			'colorscheme' => $this->getColorScheme(),
			'border_color' => $this->getBorderColor(),
			'recommendations' => (bool) $this->getRecommendations());
			
		$query = http_build_query($settings, '', '&');
		
		// start tag
		if($this->writeCopyrightTags()) $output .= "<!-- @FbTools: ActivityFeed --!>\n";
		
		// iframe tag
		$el = NHtml::el("iframe");
		$el->src = "http://www.facebook.com/plugins/activity.php?" . $query;
		$el->scrolling = "no";
		$el->frameborder = 0;
		$el->allowTransparency = "true";
			$el->style['border'] = "none";
			$el->style['overflow'] = "hidden";
			$el->style['width'] = $this->getWidth() . "px";
			$el->style['height'] = $this->getHeight() . "px";
		
		$output .= $el;
		
		// end tag
		if($this->writeCopyrightTags()) $output .= "\n<!-- /@FbTools: ActivityFeed --!>\n";
		
		echo $output;
		
	}
}