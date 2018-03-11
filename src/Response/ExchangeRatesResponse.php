<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class ExchangeRatesResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class ExchangeRatesResponse extends AbstractResponse
{

    /**
     * Response Sample
     * ```xml
     * <?xml version="1.0" encoding="UTF-8" standalone="yes"?>
     *  <exchangerates>
     *      <row>
     *          <exchangerate ccy="USD" base_ccy="UAH" buy="26.00000" sale="26.45503"/>
     *      </row>
     *      <row>
     *          <exchangerate ccy="EUR" base_ccy="UAH" buy="32.20000" sale="32.78689"/>
     *      </row>
     *      <row>
     *          <exchangerate ccy="RUR" base_ccy="UAH" buy="0.45000" sale="0.48008"/>
     *      </row>
     *      <row>
     *          <exchangerate ccy="BTC" base_ccy="USD" buy="8332.9060" sale="9210.0540"/>
     *      </row>
     *  </exchangerates>
     * ```
     * @return array
     */
    protected function getMap(): array
    {
        return [
            '{list} as row[]' => [
                'ccy' => 'exchangerate.@ccy',
                'base_ccy' => 'exchangerate.@base_ccy',
                'buy' => 'exchangerate.@buy',
                'sale' => 'exchangerate.@sale'
            ]
        ];
    }

}