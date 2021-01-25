<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesRequest;

/**
 * Class ExchangeRatesRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class ExchangeRatesRequestTest extends TestCasePublic
{
    /**
     * @return void
     * @throws PrivatBankApiException
     */
    public function testExchangeRatesCash(): void
    {
        $data = $this->client->exchangeRates(ExchangeRatesRequest::NON_CASH);
        $this->assertGreaterThan(0, count($data));
        foreach ($data as $item) {
            $this->assertArrayHasKey('ccy', $item);
            $this->assertArrayHasKey('base_ccy', $item);
            $this->assertArrayHasKey('buy', $item);
            $this->assertArrayHasKey('sale', $item);
        }
    }

    /**
     * @return void
     * @throws PrivatBankApiException
     */
    public function testExchangeRatesNonCash(): void
    {
        $data = $this->client->exchangeRates(ExchangeRatesRequest::NON_CASH);
        $this->assertGreaterThan(0, count($data));
        foreach ($data as $item) {
            $this->assertArrayHasKey('ccy', $item);
            $this->assertArrayHasKey('base_ccy', $item);
            $this->assertArrayHasKey('buy', $item);
            $this->assertArrayHasKey('sale', $item);
            break;
        }
    }
}
