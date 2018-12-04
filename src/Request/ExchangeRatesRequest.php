<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractPublicRequest;
use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesResponse;

/**
 * Class ExchangeRatesRequest
 *
 * Params:
 * coursid - int, optional, course type, see class constants
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/exchange
 */
class ExchangeRatesRequest extends AbstractPublicRequest
{

    const CASH = 5;
    const NON_CASH = 11;
    const NATIONAL_BANK_CASH = 3;

    /**
     * @return string
     */
    public function getRoute(): string
    {
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
