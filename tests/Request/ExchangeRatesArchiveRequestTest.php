<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesArchiveRequest;
use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesRequest;
use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesArchiveResponse;
use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesResponse;

/**
 * Class ExchangeRatesArchiveRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class ExchangeRatesArchiveRequestTest extends TestCase
{

    /**
     * @var ExchangeRatesRequest
     */
    private $request;

    protected function setUp()
    {
        $this->request = new ExchangeRatesArchiveRequest();
    }

    protected function tearDown()
    {
        $this->request = null;
    }

    public function testExchangeRatesCash()
    {
        $result = $this->request->execute(['date' => '01.01.2018']);
        $this->assertInstanceOf(ExchangeRatesArchiveResponse::class, $result);
        $data = $result->toArray();
        $this->assertGreaterThan(0, count($data));
        foreach ($data as $item) {
            $this->assertArrayHasKey('baseCurrency', $item);
            $this->assertArrayHasKey('currency', $item);
            $this->assertArrayHasKey('saleRateNB', $item);
            $this->assertArrayHasKey('purchaseRateNB', $item);
        }
    }

}