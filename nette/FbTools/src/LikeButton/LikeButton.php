<?php

/**
 * Like Button Control
 *
 * @package FbTools
 * @copyright Milan Felix Sulc <rkfelix@gmail.com>
 * @licence WTFPL - Do What The Fuck You Want To Public License
 * @version 1.2
 */
class FbTools_LikeButton extends NControl
{
    /**
     * Like url
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
     * Layout style [standart, button, button_count, box, box_count]
     *
     * @var string
     */
    public $layout = "standard";

    /**
     * Box width
     *
     * @var int
     */
    public $width = 450;

    /**
     * Box height
     *
     * @var int
     */
    public $height = 80;

    /**
     * Verb to display [like, recommended]
     *
     * @var string
     */
    public $type = "like";

    /**
     * Show faces
     *
     * @var bool
     */
    public $showFaces = FALSE;

    /**
     * Text fonts [arial, lucida grande, segoe ui, tahoma, trebuchet ms, verdana]
     *
     * @var string
     */
    public $font = "arial";

    /**
     * Color scheme [light, dark]
     *
     * @var string
     */
    public $colorScheme = "light";

    /**
     * Show copyright
     *
     * @var bool
     */
    public $copyright = TRUE;

    /** ************************************** SETTERS/GETTERS ************************************** */

    /**
     * @param boolean $autoUrl
     * @return FbTools_LikeButton
     */
    public function setAutoUrl($autoUrl)
    {
        $this->autoUrl = $autoUrl;
    }

    /**
     * @return boolean
     */
    public function getAutoUrl()
    {
        return $this->autoUrl;
    }

    /**
     * @param string $colorScheme
     * @return FbTools_LikeButton
     */
    public function setColorScheme($colorScheme)
    {
        $this->colorScheme = $colorScheme;
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
     * @return FbTools_LikeButton
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;
    }

    /**
     * @return boolean
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @param string $font
     * @return FbTools_LikeButton
     */
    public function setFont($font)
    {
        $fonts = array('arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana');
        if (in_array($font, $fonts)) {
            $this->font = $fonts[$font];
        } else {
            $this->font = "arial";
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @param int $height
     * @return FbTools_LikeButton
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
     * @param string $layout
     * @return FbTools_LikeButton
     */
    public function setLayout($layout)
    {
        if ($layout == 2 || $layout == "button" || $layout == "button_count") {
            $this->layout = "button_count";
        } else if ($layout == 3 || $layout == "box" || $layout == "box_count") {
            $this->layout = "box_count";
        } else {
            $this->layout = "standard";
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param bool $showFaces
     * @return FbTools_LikeButton
     */
    public function setShowFaces($showFaces)
    {
        $this->showFaces = $showFaces;
        return $this;
    }

    /**
     * @return bool
     */
    public function getShowFaces()
    {
        return $this->showFaces;
    }

    /**
     * @param string $type
     * @return FbTools_LikeButton
     */
    public function setType($type)
    {
        if ($type == 2 || $type == "recommended") {
            $this->type = "recommended";
        } else {
            $this->type = "like";
        }
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
     * @return FbTools_LikeButton
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
     * @return FbTools_LikeButton
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
    public function render($args = array())
    {
        $this->parseParams($args);
        $this->generate();
    }

    /**
     * @param array $args
     */
    public function renderFaces($args = array())
    {
        $this->parseParams($args);
        $this->setLayout(1);
        $this->setShowFaces(TRUE);
        $this->generate();
    }

    /**
     * @param array $args
     */
    public function renderButton($args = array())
    {
        $this->parseParams($args);
        $this->setLayout(2);
        $this->generate();
    }

    /**
     * @param array $args
     */
    public function renderBox($args = array())
    {
        $this->parseParams($args);
        $this->setLayout(3);
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
        // Sets width
        if (array_key_exists('width', $params)) {
            $this->setWidth($params['width']);
        }
        // Sets height
        if (array_key_exists('height', $params)) {
            $this->setHeight($params['height']);
        }
        // Sets layout
        if (array_key_exists('layout', $params)) {
            $this->setLayout($params['layout']);
        }
        // Sets type
        if (array_key_exists('type', $params)) {
            $this->setType($params['type']);
        }
        // Sets font
        if (array_key_exists('font', $params)) {
            $this->setFont($params['font']);
        }
        // Sets colorscheme
        if (array_key_exists('scheme', $params)) {
            $this->setColorScheme($params['scheme']);
        }
        // Sets show_faces
        if (array_key_exists('faces', $params)) {
            $this->setShowFaces($params['faces']);
        }
    }

    /**
     * Generating
     */
    public function generate()
    {

        // inic
        $output = NULL;

        // settings
        $settings = array(
            'href' => $this->getUrl(),
            'layout' => $this->getLayout(),
            'show_faces' => (bool)$this->getShowFaces(),
            'width' => $this->getWidth(),
            'action' => $this->getType(),
            'font' => $this->getFont(),
            'colorscheme' => $this->getColorScheme(),
            'height' => $this->getHeight());

        $query = http_build_query($settings, '', '&');

        // start tag
        if ($this->copyright) $output .= "<!-- @FbTools: LikeButton -->\n";

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
        if ($this->copyright) $output .= "\n<!-- /@FbTools: LikeButton -->\n";

        echo $output;
    }
}