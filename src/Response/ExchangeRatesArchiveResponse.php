<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class ExchangeRatesArchiveResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class ExchangeRatesArchiveResponse extends AbstractResponse
{

    /**
     * Response Sample
     * ```xml
     *  <?xml version="1.0" encoding="UTF-8" standalone="yes"?>
     *  <exchangerates date="01.12.2014" bank="PB" BaseCurrency="980" BaseCurrencyLit="UAH">
     *      <exchangerate baseCurrency="UAH" currency="AUD" saleRateNB="12.8319250" purchaseRateNB="12.8319250"/>
     *      <exchangerate baseCurrency="UAH" currency="CAD" saleRateNB="13.2107400" purchaseRateNB="13.2107400" saleRate="15.0000000" purchaseRate="13.0000000"/>
     *      <exchangerate baseCurrency="UAH" currency="CZK" saleRateNB="0.6796950" purchaseRateNB="0.6796950" saleRate="0.8000000" purchaseRate="0.6000000"/>
     *      <exchangerate baseCurrency="UAH" currency="DKK" saleRateNB="2.5258930" purchaseRateNB="2.5258930"/>
     *      <exchangerate baseCurrency="UAH" currency="HUF" saleRateNB="0.0612592" purchaseRateNB="0.0612592"/>
     *      <exchangerate baseCurrency="UAH" currency="ILS" saleRateNB="3.8627380" purchaseRateNB="3.8627380" saleRate="4.5000000" purchaseRate="3.7000000"/>
     *      <exchangerate baseCurrency="UAH" currency="JPY" saleRateNB="0.1272593" purchaseRateNB="0.1272593" saleRate="0.1500000" purchaseRate="0.1200000"/>
     *      <exchangerate baseCurrency="UAH" currency="LVL" saleRateNB="0.1272593" purchaseRateNB="0.1272593"/>
     *      <exchangerate baseCurrency="UAH" currency="LTL" saleRateNB="5.4433850" purchaseRateNB="5.4433850"/>
     *      <exchangerate baseCurrency="UAH" currency="NOK" saleRateNB="2.1609570" purchaseRateNB="2.1609570" saleRate="2.6000000" purchaseRate="2.1000000"/>
     *      <exchangerate baseCurrency="UAH" currency="SKK" saleRateNB="2.1609570" purchaseRateNB="2.1609570"/>
     *      <exchangerate baseCurrency="UAH" currency="SEK" saleRateNB="2.0283750" purchaseRateNB="2.0283750"/>
     *      <exchangerate baseCurrency="UAH" currency="CHF" saleRateNB="15.6389750" purchaseRateNB="15.6389750" saleRate="17.0000000" purchaseRate="15.5000000"/>
     *      <exchangerate baseCurrency="UAH" currency="RUB" saleRateNB="0.3052700" purchaseRateNB="0.3052700" saleRate="0.3200000" purchaseRate="0.2800000"/>
     *      <exchangerate baseCurrency="UAH" currency="GBP" saleRateNB="23.6324910" purchaseRateNB="23.6324910" saleRate="25.8000000" purchaseRate="24.0000000"/>
     *      <exchangerate baseCurrency="UAH" currency="USD" saleRateNB="15.0564130" purchaseRateNB="15.0564130" saleRate="15.7000000" purchaseRate="15.3500000"/>
     *      <exchangerate baseCurrency="UAH" currency="BYR" saleRateNB="0.0013900" purchaseRateNB="0.0013900"/>
     *      <exchangerate baseCurrency="UAH" currency="EUR" saleRateNB="18.7949200" purchaseRateNB="18.7949200" saleRate="20.0000000" purchaseRate="19.2000000"/>
     *      <exchangerate baseCurrency="UAH" currency="GEL" saleRateNB="8.1500890" purchaseRateNB="8.1500890"/>
     *      <exchangerate baseCurrency="UAH" currency="PLZ" saleRateNB="4.4922010" purchaseRateNB="4.4922010" saleRate="5.0000000" purchaseRate="4.2000000"/>
     *  </exchangerates>
     * ```
     * @return array
     */
    protected function getMap(): array
    {
        return [
            '{list} as exchangerate[]' => [
                'baseCurrency' => '@baseCurrency',
                'currency' => '@currency',
                'saleRateNB' => '@saleRateNB',
                'purchaseRateNB' => '@purchaseRateNB',
//                'saleRate' => '@saleRate',
//                'purchaseRate' => '@purchaseRate'
            ]
        ];
    }

}