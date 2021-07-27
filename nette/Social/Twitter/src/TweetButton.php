<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Social\Twitter;

use Nette\Application\UI\Control;
use Nette\Http\Url;
use Nette\Utils\Html;
use Nette\Utils\Validators;

/**
 * Twitter > tweet button
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 *
 * @property string $url
 * @property string $href
 * @property string $via
 * @property string $text
 * @property string $related
 * @property string $count
 * @property string $counturl
 * @property array  $hashtags
 * @property string $size
 * @property bool   $dnt
 * @property string $lang
 * @property Html   $elementPrototype
 * @property string $elementText
 * @property array  $properties
 */
class TweetButton extends Control
{

    /** Size constants */
    const SIZE_MEDIUM = 'medium';
    const SIZE_LARGE = 'large';

    /** Countbox constants */
    const COUNTBOX_NONE = 'none';
    const COUNTBOX_VERTICAL = 'vertical';
    const COUNTBOX_HORIZONTAL = 'horizontal';

    /** Platform URL */
    const TWITTER_PLATFORM_URL = 'https://platform.twitter.com/widgets.js';

    /** Twitter URLs */
    const TWITTER_SHARE_URL = 'https://twitter.com/share';
    const TWITTER_TWEET_URL = 'https://twitter.com/intent/tweet';

    /**
     * URL of the page to share
     *
     * @var string
     */
    private $url;

    /**
     * Twitter href (share/tweet/etc..)
     *
     * @var string
     */
    private $href = self::TWITTER_SHARE_URL;

    /**
     * Screen name of the user to attribute the Tweet to
     *
     * @var string
     */
    private $via;

    /**
     * Default Tweet text
     *
     * @var string
     */
    private $text;

    /**
     * Related accounts
     *
     * @var string
     */
    private $related;

    /**
     * Count box position
     *
     * @var string
     */
    private $count = self::COUNTBOX_VERTICAL;

    /**
     * URL to which your shared URL resolves
     *
     * @var string
     */
    private $counturl;

    /**
     * Array hashtags appended to tweet text
     *
     * @var array
     */
    private $hashtags = [];

    /**
     * The size of the rendered button
     *
     * @var string
     */
    private $size = self::SIZE_MEDIUM;

    /**
     * Help us tailor content and suggestions for Twitter users
     *
     * @var bool
     */
    private $dnt = FALSE;

    /**
     * The language for the Tweet Button
     *
     * @var string
     */
    private $lang = 'en';

    /**
     * Html element prototype
     *
     * @var Html
     */
    private $element;

    /**
     * Element inner text
     *
     * @var string
     */
    private $elementText = 'Tweet';

    /**
     * Custom element properties
     *
     * @var array
     */
    private $properties = [];

    function __construct()
    {
        $this->element = Html::el('a class="twitter twitter-button"');
    }

    /** SETTERS/GETTERS ***************************************************** */

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return self
     */
    public function setUrl($url)
    {
        Validators::assert($url, 'string|url');
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $href
     * @return self
     */
    public function setHref($href)
    {
        Validators::assert($href, 'string|url');
        $this->href = $href;
        return $this;
    }

    /**
     * @return string
     */
    public function getVia()
    {
        return $this->via;
    }

    /**
     * @param string $via
     * @return self
     */
    public function setVia($via)
    {
        $this->via = $via;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return self
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getRelated()
    {
        return $this->related;
    }

    /**
     * @param string $related
     * @return self
     */
    public function setRelated($related)
    {
        $this->related = $related;
        return $this;
    }

    /**
     * @return string
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param string $count
     * @return self
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @return string
     */
    public function getCounturl()
    {
        return $this->counturl;
    }

    /**
     * @param string $counturl
     * @return self
     */
    public function setCounturl($counturl)
    {
        Validators::assert($counturl, 'string|url');
        $this->counturl = $counturl;
        return $this;
    }

    /**
     * @return array
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }

    /**
     * @param array $hashtags
     * @return self
     */
    public function setHashtags(array $hashtags)
    {
        $this->hashtags = $hashtags;
        return $this;
    }

    /**
     * @param $hashtag
     * @return self
     */
    public function addHashtag($hashtag)
    {
        $this->hashtags[] = $hashtag;
        return $this;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     * @return self
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDnt()
    {
        return $this->dnt;
    }

    /**
     * @param boolean $dnt
     * @return self
     */
    public function setDnt($dnt)
    {
        $this->dnt = (bool)$dnt;
        return $this;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return self
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return string
     */
    public function getElementText()
    {
        return $this->elementText;
    }

    /**
     * @param string $elementText
     * @return self
     */
    public function setElementText($elementText)
    {
        $this->elementText = $elementText;
        return $this;
    }

    /**
     * @param Html $element
     */
    public function setElementPrototype($element)
    {
        $this->element = $element;
    }

    /**
     * @return Html
     */
    public function getElementPrototype()
    {
        return $this->element;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     * @return self
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return self
     */
    public function addProperty($name, $value)
    {
        $this->properties[$name] = $value;
        return $this;
    }

    /** HELPERS ************************************************************ */

    /**
     * Configure share button
     *
     * @param string $text [optional]
     */
    public function setShareButton($text = NULL)
    {
        $this->element->addClass('twitter-share-button');
        $this->href = self::TWITTER_SHARE_URL;

        if ($text) {
            $this->elementText = "Tweet $text";
        }
    }

    /**
     * Configure mention button
     *
     * @param string $mention
     */
    public function setMentionButton($mention = NULL)
    {
        $this->element->addClass('twitter-mention-button');

        // Build URL
        $url = new Url(self::TWITTER_TWEET_URL);
        $url->setQueryParameter('screen_name', $mention);
        $this->href = (string)$url;

        if ($mention) {
            $this->elementText = "Tweet to @$mention";
        }
    }

    /**
     * Configure hashtag button
     *
     * @param string $hashtag
     */
    public function setHashtagButton($hashtag = NULL)
    {
        $this->element->addClass('twitter-hashtag-button');

        // Build URL
        $url = new Url(self::TWITTER_TWEET_URL);
        $url->setQueryParameter('button_hashtag', $hashtag);
        $this->href = (string)$url;

        if ($hashtag) {
            $this->elementText = "Tweet #$hashtag";
        }
    }

    /** RENDERERS ********************************************************** */

    /**
     * Render twitter tweet button
     *
     * @param string $url [optional]
     * @return Html
     */
    public function render($url = NULL)
    {
        // Get HTML element
        $el = $this->getElementPrototype();
        $el->add($this->getElementText());
        $el->href($this->getHref());

        // Set URL
        if ($url != NULL) {
            Validators::assert($url, 'string|url');
            $el->{'data-url'} = $url;
        } else if ($this->url != NULL) {
            $el->{'data-url'} = $this->url;
        }

        // List of default properties
        $properties = [
            'via' => $this->via,
            'text' => $this->text,
            'related' => $this->related,
            'count' => $this->count,
            'lang' => $this->lang,
            'counturl' => $this->counturl,
            'hashtags' => $this->hashtags,
            'size' => $this->size,
            'dnt' => $this->dnt,
        ];

        // Merge with custom properties
        $properties = array_merge($properties, $this->getProperties());

        // Set properties as data attributes
        foreach ($properties as $key => $value) {
            if ($value !== NULL && !empty($value)) {
                $el->{"data-$key"} = $value;
            }
        }

        echo $el;
    }

    /**
     * Render twitter javascript
     *
     * @return Html
     */
    public function renderJs()
    {
        $el = Html::el('script type="text/javascript"');
        $el->add('window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="' . self::TWITTER_PLATFORM_URL . '";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));');

        echo $el;
    }


}
