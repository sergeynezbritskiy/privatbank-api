<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use DOMDocument;
use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;

/**
 * Class AbstractResponse
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var HttpResponseInterface
     */
    protected $httpResponse;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var DOMDocument
     */
    protected $xmlContent;

    /**
     * AbstractResponse constructor.
     * @param $httpResponse
     * @throws PrivatBankApiException
     */
    public function __construct(HttpResponseInterface $httpResponse)
    {
        $this->httpResponse = $httpResponse;
        $this->content = $httpResponse->getContent();
        $this->handleErrors();
    }

    /**
     * @return void
     * @throws PrivatBankApiException
     */
    protected function handleErrors()
    {
        $response = $this->httpResponse;
        if ($response->getStatusCode() !== 200) {
            throw new PrivatBankApiException($response->getReasonPhrase(), $response->getStatusCode());
        }
        $xml = $this->getXmlContent();
        /** @var \DOMNodeList $errors */
        $errors = $xml->getElementsByTagName('error');
        /** @var \DOMElement $error */
        foreach ($errors as $error) {
            $message = $error->textContent ?: $error->getAttributeNode('message')->textContent;
            throw new PrivatBankApiException($message, 500);
        }
    }

    /**
     * @return string
     */
    protected function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return DOMDocument
     */
    protected function getXmlContent(): DOMDocument
    {
        if ($this->xmlContent === null) {
            $this->xmlContent = new DOMDocument();
            $this->xmlContent->loadXML($this->getContent());
        }
        return $this->xmlContent;
    }
}
