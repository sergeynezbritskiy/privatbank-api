<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class PaymentInternalResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class PaymentInternalResponse extends AbstractResponse
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
     *          <payment id="2657374">
     *              <prop name="b_card_or_acc" value="4714466011522341" />
     *              <prop name="amt" value="10" />
     *              <prop name="ccy"  value="UAH" />
     *              <prop name="b_name" value="FIO" />
     *              <prop name="details" value="testVisa" />
     *          </payment>
     *      </data>
     *  </response>
     * ```
     * @return array
     */
    protected function getMap(): array
    {
        return [
            'merchant' => [
                'id' => 'id',
                'signature' => 'signature',
            ],
            'data' => [
                'oper' => 'oper',
                'payment as payment.prop[]' => [
                    'name' => '@name',
                    'value' => '@value',
                ],
            ],
        ];
    }
}