<?php
/**
 * Copyright (c) 2012-2014 Milan Felix Sulc <rkfelix@gmail.com>
 */

namespace NettePlugins\Response\XmlResponse;

use Nette;
use Nette\Application\IResponse;
use Nette\Http\IRequest;
use Nette\InvalidArgumentException;

/**
 * XML response
 *
 * @author Milan Felix Sulc <rkfelix@gmail.com>
 * @licence MIT
 * @version 1.0
 *
 * @property-read array|\stdClass $payload
 * @property-read string $contentType
 */
class XmlResponse implements IResponse
{

    /** @var array|\stdClass */
    private $payload;

    /** @var string */
    private $contentType;

    /** @var string */
    private $rootElement;

    /**
     * @param array|\stdClass $payload
     * @param string $rootElement root element
     * @param string $contentType content type
     * @throws InvalidArgumentException
     */
    public function __construct($payload, $rootElement = 'data', $contentType = NULL)
    {
        if (!is_array($payload) && !is_object($payload)) {
            throw new InvalidArgumentException("Payload must be array or object class, " . gettype($payload) . " given.");
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
     *
     * @return string
     */
    final public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Returns the XML root element.
     *
     * @return string
     */
    final public function getRootElement()
    {
        return $this->rootElement;
    }

    /**
     * Sends response to output.
     *
     * @param IRequest $httpRequest
     * @param IResponse $httpResponse
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
     * @param string ? $rootElement if specified will be taken as root element, otherwise defaults to <root>
     * @param SimpleXMLElement ? if specified content will be appended, used for recursion
     * @return string XML version of $array
     */
    private function encode($array, $rootElement = NULL, $xml = NULL)
    {
        $_xml = $xml;

        if ($_xml === NULL) {
            $_xml = new \SimpleXMLElement($rootElement !== NULL ? $rootElement : '<root/>');
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
