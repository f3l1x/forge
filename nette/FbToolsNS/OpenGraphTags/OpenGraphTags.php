<?php

namespace FbTools;

use Nette;

class OpenGraphTags extends Nette\Application\UI\Control {

    public $og = array(
        /* COMMON */
        'title' => NULL,
        'type' => NULL,
        'url' => NULL,
        'image' => NULL,
        'site_name' => NULL,
        'description' => NULL,
        /* LOCATION */
        'latitude' => NULL,
        'longitude' => NULL,
        'street-address' => NULL,
        'locality' => NULL,
        'region' => NULL,
        'postal-code' => NULL,
        'country-name' => NULL,
        /* CONTACT */
        'email' => NULL,
        'phone_number' => NULL,
        'fax_number' => NULL,
    );
    public $fb = array(
        /* ADMINS */
        'admins' => NULL,
        'app_id' => NULL,
    );
    public $video = array(
        /* VIDEO */
        'url' => NULL,
        'height' => NULL,
        'width' => NULL,
        'type' => NULL,
    );
    public $audio = array(
        /* AUDIO */
        'url' => NULL,
        'title' => NULL,
        'artist' => NULL,
        'type' => NULL,
    );

    /* OGT html sources */
    public $html_xmlns = "xmlns=\"http://www.w3.org/1999/xhtml\"\n
		xmlns:og=\"http://ogp.me/ns#\"\n
		xmlns:fb=\"http://www.facebook.com/2008/fbml\"";

    /* xhtml modification */
    public $xhtml = FALSE;

    /* grab auto your url */
    public $autoUrl = FALSE;

    /* for more admins ID */
    public $fbAdmins = array();

    /* COMMON */

    private function startup() {

        // HTML vs XHTML
        if ($this->isXhtml()) {
            Nette\Utils\Html::$xhtml = TRUE;
        } else {
            Nette\Utils\Html::$xhtml = FALSE;
        }

		// Split more admin users
        if (count($this->fbAdmins) > 0) {
            $this->og['admins'] = implode(', ', $this->fbAdmins);
        }
		
		// Check auto url
		if ($this->isAutoUrl()){
            $this->og['url'] = $this->presenter->context->httpRequest->getUrl();				
		}
    }

    function __set($name, $val) {

        if (Nette\Utils\Arrays::searchKey($this->og, $name) !== FALSE) {
            $this->og[$name] = Nette\Utils\Strings::normalize($val);
        } else if (Nette\Utils\Arrays::searchKey($this->fb, $name) !== FALSE) {
            $this->fb[$name] = Nette\Utils\Strings::normalize($val);
        } else {
            list($ar, $section, $name) = Nette\Utils\Strings::match($name, '/([a-zA-Z]+)[_]([a-zA-Z]*)/');

            if (Nette\Utils\Arrays::searchKey($this->$section, $name) !== FALSE) {
                $this->$section = array_replace($this->$section, array($name => $val));
            }
        }
    }

    /* GETTERS & SETTERS */

    public function isXhtml() {
        return (bool) $this->xhtml;
    }

    public function setXhtml($xhtml) {
        $this->xhtml = (boolean) $xhtml;
        return $this; //fluent interface
    }

    public function isAutoUrl() {
        return (bool) $this->autoUrl;
    }

    public function useAutoUrl() {
		$this->autoUrl = TRUE;
        return $this; //fluent interface
    }

    public function addAdmin($name) {
        $this->fbAdmins[] = Nette\Utils\Strings::normalize($name);
        return $this; //fluent interface
    }

    /* RENDERS */

    public function render() {
        $this->startup();
	
        echo $this->parse();
        echo $this->parse('fb');
        echo $this->parse('audio');
        echo $this->parse('video');
    }

    public function renderHead() {
        $this->startup();

        echo $this->html_xmlns;
    }

    public function renderOg() {
        $this->startup();

        echo $this->parse();
        echo $this->parse('fb');
    }

    public function renderAudio() {
        $this->startup();

		echo $this->parse('audio');
		echo $this->parse('fb');
    }

    public function renderVideo() {
        $this->startup();

		echo $this->parse('video');
 		echo $this->parse('fb');
   }

    /* PARSER */

    public function parse($section = 'og') {
        
		// working..
		$data = "";
        $base = $section;

		// add variable base
        if ($section == 'video' || $section == 'audio') {
            $base = "og:" . $section;
        }

		// process variables
        foreach ($this->$section as $key => $val) {
            // skip cycle
			if (is_null($val)) continue;
			
			// html element
            $el = Nette\Utils\Html::el("meta");
            $el->property = $base . ":" . $key;
            $el->content = $val;
            $data .= $el . "\n";
        }

        return $data;
    }

}