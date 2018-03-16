<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Client;

/**
 * Class AbstractRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractRequest implements RequestInterface
{

    /**
     * @return string
     */
    abstract protected function getMethod(): string;

    /**
     * @return string
     */
    abstract protected function getRoute(): string;

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    abstract protected function getResponse(HttpResponseInterface $httpResponse): ResponseInterface;

    /**
     * @param array $params
     * @return array
     */
    abstract protected function getQueryParams(array $params = []): array;

    /**
     * @param array $params
     * @return array
     */
    abstract protected function getBodyParams(array $params = []): array;

    /**
     * @var Client
     */
    private $client;

    /**
     * AbstractPublicRequest constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $params
     * @return ResponseInterface
     * @throws PrivatBankApiException
     */
    public function execute(array $params = array()): ResponseInterface
    {
        $response = $this->client->request($this->getRoute(), [
            'method' => $this->getMethod(),
            'query' => $this->getQueryParams($params),
            'body' => $this->getBody($this->getBodyParams($params)),
        ]);
        return $this->getResponse($response);

    }

    /**
     * @param array $params
     * @return string
     */
    protected function getBody(/** @noinspection PhpUnusedParameterInspection */
        array $params = []): string
    {
        return '';
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }

}