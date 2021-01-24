<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use InvalidArgumentException;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;

/**
 * Class ExchangeRatesArchiveRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class ExchangeRatesArchiveRequestTest extends TestCasePublic
{
    /**
     * @return void
     * @throws PrivatBankApiException
     */
    public function testExchangeRatesCash(): void
    {
        $month = 60 * 60 * 24 * 30;
        $data = $this->client->exchangeRatesArchive(date('d.m.Y', time() - $month));
        $this->assertGreaterThan(0, count($data));
        foreach ($data as $item) {
            $this->assertArrayHasKey('baseCurrency', $item);
            $this->assertArrayHasKey('currency', $item);
            $this->assertArrayHasKey('saleRateNB', $item);
            $this->assertArrayHasKey('purchaseRateNB', $item);
            $this->assertArrayHasKey('saleRate', $item);
            $this->assertArrayHasKey('purchaseRate', $item);
            break;
        }
    }

    /**
     * @return void
     * @throws PrivatBankApiException
     */
    public function testExchangeRatesInvalidDateFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument date must conform format d.M.Y., e.g. 01.12.2018');
        $this->client->exchangeRatesArchive(date('d-m-Y'));
    }
}
