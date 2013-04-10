<?php
/**
 * Copyright (c) 2013 Milan Felix Sulc <rkfelix@gmail.com>
 *
 * @see http://support.google.com/bin/answer.py?hl=cs&answer=1033867&rd=1
 */

/**
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 */
class GACampaign extends Object
{
    /** GA UTM FIELDS  */
    const UTM_SOURCE = 'utm_source';
    const UTM_MEDIUM = 'utm_medium';
    const UTM_CAMPAIGN = 'utm_campaign';
    const UTM_TERM = 'utm_term';
    const UTM_CONTENT = 'utm_content';

    /**
     * Campaign Source (utm_source)
     * Use utm_source to identify a search engine, newsletter name, or other source.
     *
     * @required
     * @var string
     */
    private $source;
    /**
     * Campaign Medium (utm_medium)
     * Use utm_medium to identify a medium such as email or cost-per- click.
     *
     * @required
     * @var string
     */
    private $medium;
    /**
     * Campaign Name (utm_campaign)
     * Used for keyword analysis. Use utm_campaign to identify a specific product promotion or strategic campaign.
     *
     * @required
     * @var string
     */
    private $campaign;
    /**
     * Campaign Term (utm_term)
     * Used for paid search. Use utm_term to note the keywords for this ad.
     *
     * @var string
     */
    private $term;
    /**
     * Campaign Content (utm_content)
     * Used for A/B testing and content-targeted ads. Use utm_content to differentiate ads or links
     * that point to the same URL.
     *
     * @var string
     */
    private $content;

    /**
     * @param string $source required
     * @param string $medium required
     * @param string $campaign required
     * @param string|null $term optional
     * @param string|null $content optional
     */
    function __construct($source, $medium, $campaign, $term = NULL, $content = NULL)
    {
        // Validate source & medium * campaign
        if (strlen($source) == 0) {
            throw new \Nette\InvalidStateException("GA: UTM parameter source is not filled correctly!");
        }
        if (strlen($medium) == 0) {
            throw new \Nette\InvalidStateException("GA: UTM parameter medium is not filled correctly!");
        }
        if (strlen($campaign) == 0) {
            throw new \Nette\InvalidStateException("GA: UTM parameter campaign is not filled correctly!");
        }

        $this->campaign = $campaign;
        $this->content = $content;
        $this->medium = $medium;

        if ($source != NULL) $this->source = $source;
        if ($term != NULL) $this->term = $term;
    }

    /** GETTERS/SETTERS ********************************************************************************************* */

    /**
     * @param string $campaign
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * @return string
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $medium
     */
    public function setMedium($medium)
    {
        $this->medium = $medium;
    }

    /**
     * @return string
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $term
     */
    public function setTerm($term)
    {
        $this->term = $term;
    }

    /**
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /** API ********************************************************************************************************* */

    /**
     * @return array UTM arguments
     * @throws Nette\InvalidStateException
     */
    public function build()
    {
        // Assign required parameters
        $args = array();
        $args[self::UTM_SOURCE] = $this->source;
        $args[self::UTM_MEDIUM] = $this->medium;
        $args[self::UTM_CAMPAIGN] = $this->campaign;

        // Assign optinal parameters [if they filled]
        if ($this->term != NULL) $args[self::UTM_TERM] = $this->term;
        if ($this->content != NULL) $args[self::UTM_CONTENT] = $this->content;

        // Returns arguments
        return $args;
    }

    /** FACTORY ***************************************************************************************************** */

    /**
     * @param string $source required
     * @param string $medium required
     * @param string $campaign required
     * @param string|null $term optional
     * @param string|null $content optional
     */
    public static function create($source, $medium, $campaign, $term = NULL, $content = NULL)
    {
        $app = new GACampaign($source, $medium, $campaign, $term, $content);
        return $app->build();
    }
}