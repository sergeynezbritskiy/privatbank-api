<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class PaymentResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class PaymentResponse extends AbstractResponse
{

    /**
     * Response sample
     * ```xml
     *  <?xml version="1.0" encoding="UTF-8"?>
     *  <response version="1.0">
     *      <merchant>
     *          <id>75482</id>
     *          <signature>553995c5ccc8c81815b58cf6374f68f00a28bbd7</signature>
     *      </merchant>
     *      <data>
     *          <oper>cmt</oper>
     *          <payment id="" state="1" message="" ref="P24PKP" amt="1.5" ccy="UAH" comis="0.00" cardinfo="personified"/>
     *      </data>
     *  </response>
     * ```
     * @return array
     */
    protected function getMap(): array
    {
        return [
            'payment as data.payment' => [
                'id' => '@id',
                'state' => '@state',
                'message' => '@message',
                'ref' => '@ref',
                'amt' => '@amt',
                'ccy' => '@ccy',
                'comis' => '@comis',
                'cardinfo' => '@cardinfo',
            ],
        ];
    }

    /**
     * TODO implement it via map
     * @return array
     */
    public function getData(): array
    {
        return parent::getData()['payment'];
    }


}