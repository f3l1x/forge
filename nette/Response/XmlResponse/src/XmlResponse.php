<?php

/**
 * This file is part of the Nette Framework (http://nette.org)
 *
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace Nette\Application\Responses;

use Nette;



/**
 * XML response.
 *
 * @author     Milan Sulc
 *
 * @property-read array|\stdClass $payload
 * @property-read string $contentType
 */
class XmlResponse extends Nette\Object implements Nette\Application\IResponse
{
    /** @var array|\stdClass */
    private $payload;

    /** @var string */
    private $contentType;

    /** @var string */
    private $rootElement;



    /**
     * @param  array|\stdClass  payload
     * @param  string  xml root element
     * @param  string    MIME content type
     */
    public function __construct($payload, $rootElement = 'data', $contentType = NULL)
    {
        if (!is_array($payload) && !is_object($payload)) {
            throw new Nette\InvalidArgumentException("Payload must be array or object class, " . gettype($payload) . " given.");
        }
        $this->payload = $payload;
        $this->contentType = $contentType ? $contentType : 'text/xml';
    }



    /**
     * @return array|\stdClass
     */
    final public function getPayload()
    {
        return $this->payload;
    }



    /**
     * Returns the MIME content type of a downloaded file.
     * @return string
     */
    final public function getContentType()
    {
        return $this->contentType;
    }



    /**
     * Returns the XML root element.
     * @return string
     */
    final public function getRootElement()
    {
        return $this->rootElement;
    }



    /**
     * Sends response to output.
     * @return void
     */
    public function send(Nette\Http\IRequest $httpRequest, Nette\Http\IResponse $httpResponse)
    {
        $httpResponse->setContentType($this->contentType);
        $httpResponse->setExpiration(FALSE);
        echo $this->encode($this->payload, $this->rootElement);
    }



    /**
     * @param array $array the array to be converted
     * @param string? $rootElement if specified will be taken as root element, otherwise defaults to
     *                <root>
     * @param SimpleXMLElement? if specified content will be appended, used for recursion
     * @return string XML version of $array
     */
    private function encode($array, $rootElement = null, $xml = null) {
        $_xml = $xml;

        if ($_xml === null) {
            $_xml = new \SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
        }

        foreach ($array as $k => $v) {
            if (is_array($v)) { //nested array
                $this->encode($v, $k, $_xml->addChild($k));
            } else {
                $_xml->addChild($k, $v);
            }
        }

        return $_xml->asXML();
    }

}
