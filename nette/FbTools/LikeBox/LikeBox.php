<?php
/**
 * LikeBox Control
 *
 * @package FbTools
 * @copyright Milan Felix Sulc <rkfelix@gmail.com>
 * @licence WTFPL - Do What The Fuck You Want To Public License
 * @version 1.2
 */

class FbTools_LikeBox extends NControl
{
    /**
     * Like url
     * @var string
     */
    public $url = null;

    /**
     * Box width
     * @var int
     */
    public $width = 292;

    /**
     * Box height
     * @var int
     */
    public $height = 63;

    /**
     * Color scheme
     * @var string
     */
    public $colorScheme = "light";

    /**
     * Show faces
     * @var bool
     */
    public $showFaces = false;

    /**
     * Show stream
     * @var bool
     */
    public $showStream = false;

    /**
     * Show header
     * @var bool
     */
    public $showHeader = false;

    /**
     * Show copyright
     * @var bool
     */
    public $copyright = true;

    /** ************************************** SETTERS/GETTERS ************************************** */

    /**
     * @param string $colorScheme
     * @return FbTools_LikeBox
     */
    public function setColorScheme($colorScheme)
    {
        $this->colorScheme = $colorScheme;
        return $this;
    }

    /**
     * @return string
     */
    public function getColorScheme()
    {
        return $this->colorScheme;
    }

    /**
     * @param boolean $copyright
     * @return FbTools_LikeBox
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
     * @param int $height
     * @return FbTools_LikeBox
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param boolean $showFaces
     * @return FbTools_LikeBox
     */
    public function setShowFaces($showFaces)
    {
        $this->showFaces = $showFaces;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getShowFaces()
    {
        return $this->showFaces;
    }

    /**
     * @param boolean $showHeader
     * @return FbTools_LikeBox
     */
    public function setShowHeader($showHeader)
    {
        $this->showHeader = $showHeader;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getShowHeader()
    {
        return $this->showHeader;
    }

    /**
     * @param boolean $showStream
     * @return FbTools_LikeBox
     */
    public function setShowStream($showStream)
    {
        $this->showStream = $showStream;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getShowStream()
    {
        return $this->showStream;
    }

    /**
     * @param string $url
     * @return FbTools_LikeBox
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
        return $this->url;
    }

    /**
     * @param int $width
     * @return FbTools_LikeBox
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
        if ($this->width <= 0) $this->autoHeight();
        return $this->width;
    }

    /**
     * Sets default height
     */
    public function autoHeight()
    {
        $height = 62;
        if ($this->getShowFaces() == 1) $height += 194;
        if ($this->getShowHeader() == 1) $height += 32;
        if ($this->getShowStream() == 1) $height += 331;

        $this->setHeight($height);
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
     * @param array $args
     */
    public function renderFull($args = array())
    {
        $this->parseParams($args);
        $this->setShowFaces(true);
        $this->setShowHeader(true);
        $this->setShowStream(true);
        $this->generate();
    }

    /**
     * @param array $args
     */
    public function renderStream($args = array())
    {
        $this->parseParams($args);
        $this->setShowStream(true);
        $this->generate();
    }

    /**
     * Parse control config from template
     * @param array $params
     */
    public function parseParams($params = array())
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
        if (array_key_exists('height', $params)) {
            $this->setHeight($params['height']);
        }
        // Sets colorScheme
        if (array_key_exists('colorScheme', $params)) {
            $this->setColorScheme($params['colorScheme']);
        }
        // Sets showFaces
        if (array_key_exists('showFaces', $params)) {
            $this->setShowFaces($params['showFaces']);
        }
        // Sets showHeader
        if (array_key_exists('showHeader', $params)) {
            $this->setShowHeader($params['showHeader']);
        }
        // Sets showStream
        if (array_key_exists('showStream', $params)) {
            $this->setShowStream($params['showStream']);
        }
    }

    /**
     * Generating
     */
    public function generate()
    {

        // inic
        $output = null;

        // settings
        $settings = array();
        $settings['href'] = $this->getUrl();
        $settings['width'] = $this->getWidth();
        $settings['colorscheme'] = $this->getColorScheme();
        $settings['show_faces'] = (bool)$this->getShowFaces();
        $settings['stream'] = (bool)$this->getShowStream();
        $settings['header'] = (bool)$this->getShowHeader();
        $settings['height'] = $this->getHeight();

        $query = http_build_query($settings, '', '&');

        // start tag
        if ($this->copyright) $output .= "<!-- @FbTools: LikeBox -->\n";

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
        if ($this->copyright) $output .= "\n<!-- /@FbTools: LikeBox -->\n";

        echo $output;
    }
}