<?php

namespace SergeyNezbritskiy\PrivatBank\Request;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractRequest;
use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesResponse;

/**
 * Class ExchangeRatesRequest
 * @package SergeyNezbritskiy\PrivatBank\Request
 */
class ExchangeRatesRequest extends AbstractRequest
{

    const CASH = 5;
    const NON_CASH = 11;
    const NATIONAL_BANK_CASH = 3;

    /**
     * @return string
     */
    public function getRoute(): string
    {
        /** @noinspection SpellCheckingInspection */
        return 'pubinfo';
    }

    /**
     * @param array $params
     * @return array
     */
    public function getQueryParams(array $params = []): array
    {
        $params = array_merge([
            'coursid' => self::CASH,
        ], $params);
        return [
            'exchange' => '',
            'coursid' => $params['coursid'],
        ];
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    public function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new ExchangeRatesResponse($httpResponse);
    }

}