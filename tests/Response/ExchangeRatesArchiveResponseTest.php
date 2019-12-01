<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesArchiveResponse;

/**
 * Class ExchangeRatesArchiveResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class ExchangeRatesArchiveResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return ExchangeRatesArchiveResponse::class;
    }

    //tests
    public function testSuccessfulResponse()
    {
        $this->content = <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<exchangerates date="01.12.2014" bank="PB" BaseCurrency="980" BaseCurrencyLit="UAH">
    <exchangerate baseCurrency="UAH" currency="AUD" saleRateNB="12.8319250" purchaseRateNB="12.8319250"/>
    <exchangerate baseCurrency="UAH" currency="CAD" saleRateNB="13.2107400" purchaseRateNB="13.2107400" 
    saleRate="15.0000000" purchaseRate="13.0000000"/>
</exchangerates>
XML;
        $this->buildResponseMock();

        $result = $this->response->getData();
        $this->assertEquals([
            [
                'baseCurrency' => 'UAH',
                'currency' => 'AUD',
                'saleRateNB' => '12.8319250',
                'purchaseRateNB' => '12.8319250',
                'saleRate' => '',
                'purchaseRate' => '',
            ],
            [
                'baseCurrency' => 'UAH',
                'currency' => 'CAD',
                'saleRateNB' => '13.2107400',
                'purchaseRateNB' => '13.2107400',
                'saleRate' => '15.0000000',
                'purchaseRate' => '13.0000000',
            ]
        ], $result);
    }
}
