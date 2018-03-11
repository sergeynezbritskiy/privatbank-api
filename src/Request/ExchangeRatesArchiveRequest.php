<?php

namespace SergeyNezbritskiy\PrivatBank\Request;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractRequest;
use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesArchiveResponse;

/**
 * Class ExchangeRatesArchiveRequest
 * Params:
 * date - required, string, format d.m.Y, e.g. 01.12.2017
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/exchangeArchive
 */
class ExchangeRatesArchiveRequest extends AbstractRequest
{

    const CASH = 5;
    const NON_CASH = 11;
    const NATIONAL_BANK_CASH = 3;

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return 'exchange_rates';
    }

    /**
     * @param array $params
     * @return array
     */
    public function getQueryParams(array $params = []): array
    {
        $params = array_merge([
            'date' => '',
        ], $params);
        return [
            'date' => $params['date'],
        ];
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    public function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new ExchangeRatesArchiveResponse($httpResponse);
    }

}