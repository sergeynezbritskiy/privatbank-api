<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;

/**
 * Class AbstractPublicRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractPublicRequest implements RequestInterface
{

    /**
     * @var string
     */
    protected $url = 'https://api.privatbank.ua/p24api/';

    /**
     * @var \SergeyNezbritskiy\PrivatBank\Client
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
     * @param \SergeyNezbritskiy\PrivatBank\Client $client
     */
    public function __construct(\SergeyNezbritskiy\PrivatBank\Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $params
     * @return ResponseInterface
     */
    public function execute(array $params = array()): ResponseInterface
    {
        $client = new Client();

        $requestUri = $this->url . $this->getRoute();
        $response = $client->request('GET', $requestUri, [
            'query' => $this->getQueryParams($params)
        ]);
        return $this->getResponse($response);
    }

}