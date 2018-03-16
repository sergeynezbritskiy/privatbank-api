<?php

namespace SergeyNezbritskiy\PrivatBank\Base;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\XmlIo\XmlReader;

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
     * AbstractResponse constructor.
     * @param $httpResponse
     * @throws PrivatBankApiException
     */
    public function __construct(HttpResponseInterface $httpResponse)
    {
        $this->httpResponse = $httpResponse;
        $this->content = $httpResponse->getBody()->getContents();
        $this->handleErrors();
    }

    /**
     * @return array
     */
    abstract protected function getMap(): array;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return (new XmlReader())->toArray($this->getContent(), $this->getMap());
    }

    /**
     * @return string
     */
    protected function getContent(): string
    {
        return $this->content;
    }

    /**
     * @throws PrivatBankApiException
     */
    private function handleErrors()
    {
        $statusCode = $this->httpResponse->getStatusCode();
        if ($statusCode !== 200) {
            throw new PrivatBankApiException($this->httpResponse->getReasonPhrase(), $statusCode);
        }
    }

}