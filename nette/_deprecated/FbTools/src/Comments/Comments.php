<?php

/**
 * Comments Control
 *
 * @package FbTools
 * @copyright Milan Felix Sulc <rkfelix@gmail.com>
 * @licence WTFPL - Do What The Fuck You Want To Public License
 * @version 1.2
 */
class FbTools_Comments extends NControl
{
    /**
     * Comment url
     *
     * @var string
     */
    public $url = NULL;

    /**
     * Auto get url
     *
     * @var bool
     */
    public $autoUrl = FALSE;

    /**
     * Box width
     *
     * @var int
     */
    public $width = 450;

    /**
     * Number of posts
     *
     * @var int
     */
    public $numPosts = 10;

    /**
     * Show copyright
     *
     * @var bool
     */
    public $copyright = TRUE;

    /** ************************************** SETTERS/GETTERS ************************************** */

    /**
     * @param boolean $autoUrl
     * @return FbTools_Comments
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
     * @return FbTools_Comments
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
     * @param int $numPosts
     * @return FbTools_Comments
     */
    public function setNumPosts($numPosts)
    {
        $this->numPosts = $numPosts;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumPosts()
    {
        return $this->numPosts;
    }

    /**
     * @param string $url
     * @return FbTools_Comments
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
        if ($this->autoUrl) {
            return (string)NEnvironment::getHttpRequest()->getUrl();
        } else {
            return $this->url;
        }
    }

    /**
     * @param int $width
     * @return FbTools_Comments
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /** ************************************** RENDERS ************************************** */

    /**
     * @param array $args
     */
    public function render($args = [])
    {
        $this->parseParams($args);
        $this->generate();
    }

    /**
     * Parse control config from template
     *
     * @param array $params
     */
    public function parseParams($params = [])
    {
        // Sets url
        if (array_key_exists('url', $params)) {
            $this->setUrl($params['url']);
        }
        // Sets width
        if (array_key_exists('width', $params)) {
            $this->setWidth($params['width']);
        }
        // Sets height
        if (array_key_exists('posts', $params)) {
            $this->setNumPosts($params['posts']);
        }
    }

    /**
     * Generating
     */
    public function generate()
    {
        // inic
        $output = NULL;

        // start tag
        if ($this->copyright) $output .= "<!-- @FbTools: Comments -->\n";

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
        if ($this->copyright) $output .= "\n<!-- /@FbTools: Comments -->\n";

        echo $output;
    }
}