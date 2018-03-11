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
    private $httpResponse;

    /**
     * AbstractResponse constructor.
     * @param $httpResponse
     */
    public function __construct(HttpResponseInterface $httpResponse)
    {
        $this->httpResponse = $httpResponse;
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
        return $this->httpResponse->getBody()->getContents();
    }

}