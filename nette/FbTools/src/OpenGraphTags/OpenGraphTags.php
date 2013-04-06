<?php
/**
 * OGT - Open Graph Tags Control
 *
 * @package FbTools
 * @copyright Milan Felix Sulc <rkfelix@gmail.com>
 * @licence WTFPL - Do What The Fuck You Want To Public License
 * @version 1.2
 */

class FbTools_OpenGraphTags extends NControl
{
    /**
     * Www url
     * @var string
     */
    public $url = null;

    /**
     * Auto get url
     * @var bool
     */
    public $autoUrl = false;

    /**
     * Www title
     * @var string
     */
    public $title;

    /**
     * Www category
     * @var string
     */
    public $type = "website";

    /**
     * Www image
     * @var string
     */
    public $image;

    /**
     * Www sitename
     * @var string
     */
    public $site_name;

    /**
     * Facebook user ID
     * Facebook Platform application ID
     * @var int
     */
    public $app_id = 0;

    /**
     * Xhtml|Html
     * @var bool
     */
    public $xhtml = false;

    /**
     * Show copyright
     * @var bool
     */
    public $copyright = true;

    /** ************************************** SETTERS/GETTERS ************************************** */

    /**
     * @param int $app_id
     * @return FbTools_OpenGraphTags
     */
    public function setAppId($app_id)
    {
        $this->app_id = $app_id;
        return $this;
    }

    /**
     * @param $admin_id
     * @return FbTools_OpenGraphTags
     */
    public function setAdminId($admin_id)
    {
        $this->app_id = $admin_id;
        return $this;
    }

    /**
     * @param $fb_id
     * @return FbTools_OpenGraphTags
     */
    public function setFbId($fb_id)
    {
        $this->app_id = $fb_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     * @param boolean $autoUrl
     * @return FbTools_OpenGraphTags
     */
    public function setAutoUrl($autoUrl)
    {
        $this->autoUrl = $autoUrl;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getAutoUrl()
    {
        return $this->autoUrl;
    }

    /**
     * @param boolean $copyright
     * @return FbTools_OpenGraphTags
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @param string $image
     * @return FbTools_OpenGraphTags
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $site_name
     * @return FbTools_OpenGraphTags
     */
    public function setSiteName($site_name)
    {
        $this->site_name = $site_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSiteName()
    {
        return $this->site_name;
    }

    /**
     * @param string $title
     * @return FbTools_OpenGraphTags
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $type
     * @return FbTools_OpenGraphTags
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $url
     * @return FbTools_OpenGraphTags
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if ($this->isAutoUrl()) {
            return (string)NEnvironment::getHttpRequest()->getUri();
        } else {
            return $this->url;
        }
    }

    /**
     * @param boolean $xhtml
     * @return FbTools_OpenGraphTags
     */
    public function setXhtml($xhtml)
    {
        $this->xhtml = $xhtml;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getXhtml()
    {
        return $this->xhtml;
    }

    /** ************************************** RENDERS ************************************** */

    /**
     * @param array $args
     */
    public function render($args = array())
    {
        $this->parseParams($args);
        $this->generate();
    }

    /**
     * Parse control config from template
     *
     * @param array $params
     */
    public function parseParams($params = array())
    {
        // Sets url
        if (array_key_exists('url', $params)) {
            $this->setUrl($params['url']);
        }
        // Sets title
        if (array_key_exists('title', $params)) {
            $this->setTitle($params['title']);
        }
        // Sets image
        if (array_key_exists('image', $params)) {
            $this->setImage($params['image']);
        }
        // Sets site_name
        if (array_key_exists('site_name', $params)) {
            $this->setSiteName($params['site_name']);
        }
        // Sets app_id/admin_id/fb_id
        // app_id
        if (array_key_exists('app_id', $params)) {
            $this->setAppId($params['app_id']);
        }
        // admin_id
        if (array_key_exists('admin_id', $params)) {
            $this->setAdminId($params['admin_id']);
        }
        // fb_id
        if (array_key_exists('fb_id', $params)) {
            $this->setFbId($params['fb_id']);
        }
    }

    /**
     * Generating
     */
    public function generate()
    {
        // Sets Xhtml or Html
        if ($this->isXhtml()) {
            NHtml::$xhtml = true;
        } else {
            NHtml::$xhtml = false;
        }

        // inic
        $output = null;

        // start tag
        if ($this->copyright()) $output .= "<!-- @FbTools: OpenGraphTags -->\n";

        // OG TAGS
        $output .= $this->makeTag('og:title', $this->getTitle());
        $output .= $this->makeTag('og:type', $this->getType());
        $output .= $this->makeTag('og:url', $this->getUrl());
        $output .= $this->makeTag('og:image', $this->getImage());
        $output .= $this->makeTag('og:site_name', $this->getSiteName());
        $output .= $this->makeTag('fb:admins', $this->getAppId());

        // end tag
        if ($this->copyright) $output .= "<!-- /@FbTools: OpenGraphTags -->\n";

        echo $output;
    }

    /**
     * @param $key
     * @param $value
     * @return null|NHtml
     */
    public function makeTag($key, $value)
    {
        if (empty($value) || empty($key)) return null;
        $el = NHtml::el("meta");
        $el->property = $key;
        $el->content = $value;
        return $el;
    }
}