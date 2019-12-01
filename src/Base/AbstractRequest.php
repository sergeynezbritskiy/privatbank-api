<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;

/**
 * Class AbstractRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractRequest implements RequestInterface
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $params;

    /**
     * @return string
     */
    abstract protected function getRoute(): string;

    /**
     * @return string
     */
    abstract protected function getMethod(): string;

    /**
     * @return array
     */
    abstract protected function getQuery(): array;

    /**
     * @return array
     */
    abstract protected function getBodyParams(): array;

    /**
     * @param array $params
     * @return string
     */
    abstract protected function getBody(array $params = []): string;

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    abstract protected function getResponse(HttpResponseInterface $httpResponse): ResponseInterface;

    /**
     * @return array
     */
    abstract protected function getValidationRules(): array;

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
    public function execute(array $params = []): ResponseInterface
    {
        $this->params = $this->validateParams($params);
        $response = $this->client->request($this->getRoute(), [
            'method' => $this->getMethod(),
            'query' => $this->getQuery(),
            'body' => $this->getBody($this->getBodyParams()),
        ]);
        return $this->getResponse($response);
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return array
     */
    protected function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return array
     */
    private function validateParams(array $params): array
    {
        return (new Validator())->validate($params, $this->getValidationRules());
    }
}
