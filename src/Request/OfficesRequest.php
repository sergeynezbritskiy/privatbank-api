<?php

namespace SergeyNezbritskiy\PrivatBank\Request;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractRequest;
use SergeyNezbritskiy\PrivatBank\Response\OfficesResponse;

/**
 * Class ExchangeRatesArchiveRequest
 * Params:
 * address - string, optional russian language
 * city - string, optional, in russian language
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/branch
 */
class OfficesRequest extends AbstractRequest
{

    const CASH = 5;
    const NON_CASH = 11;
    const NATIONAL_BANK_CASH = 3;

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return 'pboffice';
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
        return new OfficesResponse($httpResponse);
    }

}