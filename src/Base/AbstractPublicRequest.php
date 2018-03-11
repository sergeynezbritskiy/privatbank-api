<?php

namespace SergeyNezbritskiy\PrivatBank\Base;

use GuzzleHttp\Client;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;

/**
 * Class AbstractPublicRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractPublicRequest extends AbstractRequest
{

    /**
     * @param array $params
     * @return array
     */
    abstract protected function getQueryParams(array $params = []): array;

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