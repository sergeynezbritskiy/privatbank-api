<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesArchiveRequest;
use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesRequest;
use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesArchiveResponse;

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
        $this->request = new ExchangeRatesArchiveRequest(new Client());
    }

    protected function tearDown()
    {
        $this->request = null;
    }

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testExchangeRatesCash()
    {
        $month = 60 * 60 * 24 * 30;
        $result = $this->request->execute(['date' => date('d.m.Y', time() - $month)]);
        $this->assertInstanceOf(ExchangeRatesArchiveResponse::class, $result);
        $data = $result->getData();
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

}