<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class PaymentMobileResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class PaymentMobileResponse extends AbstractResponse
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
     *          <payment id="SIVN1392995003.855" state="1" auto_id="144266960" message="" ref="" amt="0.06" ccy="UAH" comis="0.0" code="" />
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
                'auto_id' => '@auto_id',
                'message' => '@message',
                'ref' => '@ref',
                'amt' => '@amt',
                'ccy' => '@ccy',
                'comis' => '@comis',
                'code' => '@code',
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