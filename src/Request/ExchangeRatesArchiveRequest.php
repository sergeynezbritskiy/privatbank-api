<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use InvalidArgumentException;
use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractPublicRequest;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Base\Validator;
use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesArchiveResponse;

/**
 * Class ExchangeRatesArchiveRequest
 *
 * Params:
 * date - required, string, format d.m.Y, e.g. 01.12.2017
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/exchangeArchive
 */
class ExchangeRatesArchiveRequest extends AbstractPublicRequest
{

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return 'exchange_rates';
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        $params = $this->getParams();
        return [
            'date' => $params['date'],
        ];
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     * @throws PrivatBankApiException
     */
    public function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new ExchangeRatesArchiveResponse($httpResponse);
    }

    /**
     * @return array
     */
    protected function getValidationRules(): array
    {
        $callback = function ($params) {
            $dateInput = $params['date'];
            $date = date_create_from_format('d.m.Y', $params['date']);
            if (($date === false) || ($date->format('d.m.Y') !== $dateInput)) {
                throw new InvalidArgumentException('Argument date must conform format d.M.Y., e.g. 01.12.2018');
            }
        };
        return [
            ['date', Validator::TYPE_REQUIRED],
            ['date', $callback],
        ];
    }
}
