<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractPublicRequest;
use SergeyNezbritskiy\PrivatBank\Base\Validator;
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

    public const CASH = 5;
    public const NON_CASH = 11;
    public const NATIONAL_BANK_CASH = 3;

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return 'pubinfo';
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        $params = $this->getParams();
        return [
            'exchange' => '',
            'coursid' => $params['coursid'],
        ];
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new ExchangeRatesResponse($httpResponse);
    }

    /**
     * @return array
     */
    protected function getValidationRules(): array
    {
        return [
            ['coursid', Validator::TYPE_DEFAULT, 'value' => self::CASH],
        ];
    }
}
