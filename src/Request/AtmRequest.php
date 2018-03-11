<?php

namespace SergeyNezbritskiy\PrivatBank\Request;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractRequest;
use SergeyNezbritskiy\PrivatBank\Response\AtmResponse;

/**
 * Class AtmRequest
 * Params:
 * address - string, optional russian language
 * city - string, optional, in russian language
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/atm
 */
class AtmRequest extends AbstractRequest
{

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return 'infrastructure';
    }

    /**
     * @param array $params
     * @return array
     */
    public function getQueryParams(array $params = []): array
    {
        $params = array_merge([
            'city' => '',
            'address' => ''
        ], $params);
        return [
            'atm' => '',
            'city' => $params['city'],
            'address' => $params['address'],
        ];
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    public function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new AtmResponse($httpResponse);
    }

}