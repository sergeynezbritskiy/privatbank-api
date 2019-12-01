<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Response\ExchangeRatesResponse;

/**
 * Class ExchangeRatesResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class ExchangeRatesResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return ExchangeRatesResponse::class;
    }

    //tests
    public function testSuccessfulResponse()
    {
        $this->content = <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<exchangerates>
    <row>
        <exchangerate ccy="USD" base_ccy="UAH" buy="26.00000" sale="26.45503"/>
    </row>
    <row>
        <exchangerate ccy="EUR" base_ccy="UAH" buy="32.20000" sale="32.78689"/>
    </row>
    <row>
        <exchangerate ccy="RUR" base_ccy="UAH" buy="0.45000" sale="0.48008"/>
    </row>
    <row>
        <exchangerate ccy="BTC" base_ccy="USD" buy="8332.9060" sale="9210.0540"/>
    </row>
</exchangerates>
XML;
        $this->buildResponseMock();

        $result = $this->response->getData();
        $this->assertEquals([[
            'ccy' => 'USD',
            'base_ccy' => 'UAH',
            'buy' => 26.0,
            'sale' => 26.45503,
        ], [
            'ccy' => 'EUR',
            'base_ccy' => 'UAH',
            'buy' => 32.2,
            'sale' => 32.78689,
        ], [
            'ccy' => 'RUR',
            'base_ccy' => 'UAH',
            'buy' => 0.45,
            'sale' => 0.48008,
        ], [
            'ccy' => 'BTC',
            'base_ccy' => 'USD',
            'buy' => 8332.906,
            'sale' => 9210.054,
        ]], $result);
    }
}
