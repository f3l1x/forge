<?php

/**
 * Activity Feed Control
 *
 * @package FbTools
 * @copyright Milan Felix Sulc <rkfelix@gmail.com>
 * @licence WTFPL - Do What The Fuck You Want To Public License
 * @version 1.2
 */
class FbTools_ActivityFeed extends NControl
{
    /**
     * Activity feed url
     *
     * @var string
     */
    public $url = NULL;

    /**
     * Box width
     *
     * @var int
     */
    public $width = 300;

    /**
     * Box height
     *
     * @var int
     */
    public $height = 300;

    /**
     * Show header
     *
     * @var bool
     */
    public $showHeader = TRUE;

    /**
     * Color scheme
     *
     * @var string
     */
    public $colorScheme = "light";

    /**
     * Font
     *
     * @var string
     */
    public $font = "arial";

    /**
     * Border color
     *
     * @var string
     */
    public $borderColor = NULL;

    /**
     * Recommendations
     *
     * @var int
     */
    public $recommendations = 0;

    /**
     * Show copyright
     *
     * @var bool
     */
    public $copyright = TRUE;

    /** ************************************** SETTERS/GETTERS ************************************** */

    /**
     * @param string $borderColor
     * @return FbTools_ActivityFeed
     */
    public function setBorderColor($borderColor)
    {
        $this->borderColor = $borderColor;
        return $this;
    }

    /**
     * @return string
     */
    public function getBorderColor()
    {
        return $this->borderColor;
    }

    /**
     * @param string $colorScheme
     * @return FbTools_ActivityFeed
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
     * @return FbTools_ActivityFeed
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
     * @param string $font
     * @return FbTools_ActivityFeed
     */
    public function setFont($font)
    {
        switch ($font) {
            case "lucida grande":
                $this->font = "arial";
                break;
            case "segoe ui":
                $this->font = "segoe ui";
                break;
            case "tahoma":
                $this->font = "tahoma";
                break;
            case "trebuchet ms":
                $this->font = "trebuchet ms";
                break;
            case "verdana":
                $this->font = "verdana";
                break;
            default:
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
     * @return FbTools_ActivityFeed
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
     * @param int $recommendations
     * @return FbTools_ActivityFeed
     */
    public function setRecommendations($recommendations)
    {
        $this->recommendations = $recommendations;
        return $this;
    }

    /**
     * @return int
     */
    public function getRecommendations()
    {
        return $this->recommendations;
    }

    /**
     * @param boolean $showHeader
     * @return FbTools_ActivityFeed
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
     * @param string $url
     * @return FbTools_ActivityFeed
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
     * @return FbTools_ActivityFeed
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
    public function renderDark($args = array())
    {
        $this->parseParams($args);
        $this->setColorScheme("dark");
        $this->generate();
    }

    /**
     * @param array $args
     */
    public function renderLight($args = array())
    {
        $this->parseParams($args);
        $this->setColorScheme("light");
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
        // Sets show header
        if (array_key_exists('showHeader', $params)) {
            $this->setShowHeader($params['showHeader']);
        }
        // Sets color scheme
        if (array_key_exists('colorScheme', $params)) {
            $this->setColorScheme($params['colorScheme']);
        }
        // Sets border color
        if (array_key_exists('borderColor', $params)) {
            $this->setBorderColor($params['borderColor']);
        }
        // Sets height
        if (array_key_exists('recommendations', $params)) {
            $this->setRecommendations($params['recommendations']);
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
            'site' => $this->getUrl(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'header' => (bool)$this->getShowHeader(),
            'colorscheme' => $this->getColorScheme(),
            'border_color' => $this->getBorderColor(),
            'recommendations' => (bool)$this->getRecommendations());

        $query = http_build_query($settings, '', '&');

        // start tag
        if ($this->copyright) $output .= "<!-- @FbTools: ActivityFeed -->\n";

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
        if ($this->copyright) $output .= "\n<!-- /@FbTools: ActivityFeed -->\n";

        echo $output;
    }
}