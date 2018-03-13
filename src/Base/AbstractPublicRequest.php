<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Client;

/**
 * Class AbstractPublicRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractPublicRequest implements RequestInterface
{

    /**
     * @var Client
     */
    private $client;

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
     */
    public function execute(array $params = array()): ResponseInterface
    {
        $response = $this->client->request($this->getRoute(), [
            'query' => $this->getQueryParams($params)
        ]);
        return $this->getResponse($response);
    }

}