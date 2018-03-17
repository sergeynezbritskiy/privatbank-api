<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesRequest;
use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesResponse;

/**
 * Class ExchangeRatesRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class ExchangeRatesRequestTest extends TestCase
{

    /**
     * @var ExchangeRatesRequest
     */
    private $request;

    protected function setUp()
    {
        $this->request = new ExchangeRatesRequest(new Client());
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
        $result = $this->request->execute(['coursid' => ExchangeRatesRequest::CASH]);
        $this->assertInstanceOf(ExchangeRatesResponse::class, $result);
        $data = $result->toArray();
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
        $result = $this->request->execute(['coursid' => ExchangeRatesRequest::NON_CASH]);
        $this->assertInstanceOf(ExchangeRatesResponse::class, $result);
        $data = $result->toArray();
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