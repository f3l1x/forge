<?php
/**
 * OpenGraphTags control
 *
 * @package #FbTools
 * @copyright Milan Felix Sulx
 * @licence WTFPL - Do What The Fuck You Want To Public License 
 * @version 1.1
 */

/**
Facebook Attributes
    og:title - The title of the entity.
    og:type - The type of entity. You must select a type from the list of Open Graph types.
    og:image - The URL to an image that represents the entity. Images must be at least 50 pixels by 50 pixels. Square images work best, but you are allowed to use images up to three times as wide as they are tall.
    og:url - The canonical, permanent URL of the page representing the entity. When you use Open Graph tags, the Like button posts a link to the og:url instead of the URL in the Like button code.
    og:site_name - A human-readable name for your site, e.g., "IMDb".
    fb:admins or fb:app_id - A comma-separated list of either the Facebook IDs of page administrators or a Facebook Platform application ID. At a minimum, include only your own Facebook ID.
*/

class FbTools_OpenGraphTags extends NControl
{
	// www url
	public $url = null;
	
	// auto get url
	public $autoUrl = false;
	
	// www title
	public $title;
	
	// www category
	public $type = "website";

	// www image
	public $image;
	
	// www site name
	public $site_name;
	
	// Facebook user ID/Facebook Platform application ID
	public $app_id = 0;
	
	// xhtml />
	public $xhtml = false;
	
	// copyright
	public $copyright = true;
	
	/*
	 * Setters
	 */
	public function setUrl($url){
		$this->url = $url;
		return $this; //fluent interface
	}
	
	public function setTitle($title){
		$this->title = $title;
		return $this; //fluent interface
	}

	public function setType($type){
		$this->type = $type;
		return $this; //fluent interface
	}

	public function setImage($image){
		$this->image = $image;
		return $this; //fluent interface
	}

	public function setSiteName($site_name){
		$this->site_name = $site_name;
		return $this; //fluent interface
	}

	public function setAppId($app_id){
		$this->app_id = $app_id;
		return $this; //fluent interface
	}

	public function setAdminId($admin_id){
		$this->setAppId($admin_id);
		return $this; //fluent interface
	}
	
	public function setFbId($fb_id){
		$this->setAppId($fb_id);
		return $this; //fluent interface
	}

	public function setAutoUrl($autoUrl){
		$this->autoUrl = $autoUrl;	
		return $this; //fluent interface
	}

	public function setXhtml($xhtml){
		$this->xhtml = $xhtml;	
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
		if($this->isAutoUrl()){
			return (string) NEnvironment::getHttpRequest()->getUri();	
		}else{
			return $this->url;	
		}
	}

	public function getTitle(){
		return $this->title;	
	}

	public function getType(){
		return $this->type;	
	}

	public function getImage(){
		return $this->image;	
	}
	
	public function getSiteName(){
		return $this->site_name;	
	}

	public function getAppId(){
		return (int) $this->app_id;	
	}

	public function getAdminId(){
		return(int)  $this->app_id;	
	}

	public function getFbId(){
		return (int) $this->app_id;	
	}

	public function isAutoUrl(){
		return $this->autoUrl;	
	}

	public function isXhtml(){
		return $this->xhtml;
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
		
	/* parse control config from template */
	public function parseParams($params = array()){
		// set up url
		if(array_key_exists('url', $params))
			$this->setUrl($params['url']);	
		// set up title
		if(array_key_exists('title', $params))
			$this->setTitle($params['title']);	
		// set up image
		if(array_key_exists('image', $params))
			$this->setImage($params['image']);	
		// set up site_name
		if(array_key_exists('site_name', $params))
			$this->setSiteName($params['site_name']);	
		// set up app_id/admin_id/fb_id
		// app_id
		if(array_key_exists('app_id', $params))
			$this->setAppId($params['app_id']);	
			// admin_id
			if(array_key_exists('admin_id', $params))
				$this->setAdminId($params['admin_id']);	
			// fb_id
			if(array_key_exists('fb_id', $params))
				$this->setFbId($params['fb_id']);	
	}

	/*
	 * Generating
	 */
	public function generate(){
		
		if($this->isXhtml()) 
			NHtml::$xhtml = true; 
		else NHtml::$xhtml = false;
		
		// inic
		$output = null;

		// start tag
		if($this->writeCopyrightTags()) $output .= "<!-- @FbTools: OpenGraphTags --!>\n";
		
		// og tags
		//title
		$output .= $this->generateTitle($this->getTitle());
		//type
		$output .= $this->generateType($this->getType());
		//url
		$output .= $this->generateUrl($this->getUrl());
		//image
		$output .= $this->generateImage($this->getImage());
		//site_name
		$output .= $this->generateSiteName($this->getSiteName());
		//admins
		$output .= $this->generateAdmins($this->getAppId());
		
		// end tag
		if($this->writeCopyrightTags()) $output .= "<!-- /@FbTools: OpenGraphTags --!>\n";
		
		echo $output;
	}
	
	public function generateTitle($title){
		if(empty($title)) return null;
 		$og_title = NHtml::el("meta");
		$og_title->property = "og:title";
		$og_title->content = $title;
		return $og_title."\n";
	}

	public function generateType($type){
		if(empty($type)) return null;
 		$og_type = NHtml::el("meta");
		$og_type->property = "og:type";
		$og_type->content = $type;
		return $og_type."\n";
	}

	public function generateUrl($url){
		if(empty($url)) return null;
 		$og_url = NHtml::el("meta");
		$og_url->property = "og:url";
		$og_url->content = $url;
		return $og_url."\n";
	}	

	public function generateImage($image){
		if(empty($image)) return null;
 		$og_image = NHtml::el("meta");
		$og_image->property = "og:image";
		$og_image->content = $image;
		return $og_image."\n";
	}	

	public function generateSiteName($site_name){
		if(empty($site_name)) return null;
 		$og_site_name = NHtml::el("meta");
		$og_site_name->property = "og:site_name";
		$og_site_name->content = $site_name;
		return $og_site_name."\n";
	}	

	public function generateAdmins($admins){
		if(empty($admins) or !is_numeric($admins)) return null;
 		$og_admins = NHtml::el("meta");
		$og_admins->property = "fb:admins";
		$og_admins->content = (int) $admins;
		return $og_admins."\n";
	}		
	
}