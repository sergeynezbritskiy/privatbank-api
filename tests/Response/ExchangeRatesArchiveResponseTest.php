<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\tests\Response;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesArchiveResponse;

/**
 * Class ExchangeRatesArchiveResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class ExchangeRatesArchiveResponseTest extends TestCase
{
    /**
     * @var ExchangeRatesArchiveResponse
     */
    private $response;
    private $content = array();

    protected function setUp()
    {
        $test = $this;
        $stream = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['getContents'])
            ->getMock();
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturnCallback(function () use ($test) {
                return $test->content;
            });

        /** @var Response|MockObject $httpResponse */
        $httpResponse = $this->getMockBuilder(Response::class)
            ->setMethods(['getBody'])
            ->getMock();
        $httpResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);
        $this->response = new ExchangeRatesArchiveResponse($httpResponse);
    }

    public function tearDown()
    {
        $this->response = null;
    }

    public function testSuccessfulResponse()
    {
        $this->content = <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<exchangerates date="01.12.2014" bank="PB" BaseCurrency="980" BaseCurrencyLit="UAH">
    <exchangerate baseCurrency="UAH" currency="AUD" saleRateNB="12.8319250" purchaseRateNB="12.8319250"/>
    <exchangerate baseCurrency="UAH" currency="CAD" saleRateNB="13.2107400" purchaseRateNB="13.2107400" saleRate="15.0000000" purchaseRate="13.0000000"/>
</exchangerates>
XML;

        $result = $this->response->toArray();
        $this->assertEquals([[
            'baseCurrency' => 'UAH',
            'currency' => 'AUD',
            'saleRateNB' => '12.8319250',
            'purchaseRateNB' => '12.8319250',
        ], [
            'baseCurrency' => 'UAH',
            'currency' => 'CAD',
            'saleRateNB' => '13.2107400',
            'purchaseRateNB' => '13.2107400',
        ]], $result);
    }
}