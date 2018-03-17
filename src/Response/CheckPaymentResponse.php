<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class CheckPaymentResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class CheckPaymentResponse extends AbstractResponse
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
     *          <payment id="1234567" status="ok" message="Исполнен" ref="P24A02509023364480" />
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
                'status' => '@status',
                'message' => '@message',
                'ref' => '@ref',
            ],
        ];
    }

    /**
     * TODO implement it via map
     * @return array
     */
    public function toArray(): array
    {
        return parent::toArray()['payment'];
    }

}