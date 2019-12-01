<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesRequest;

/**
 * Class ExchangeRatesRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class ExchangeRatesRequestTest extends TestCasePublic
{

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testExchangeRatesCash()
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
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testExchangeRatesNonCash()
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
