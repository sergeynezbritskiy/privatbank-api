<?php

declare(strict_types=1);

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
    public function getData(): array
    {
        $xml = $this->getXmlContent();
        /** @var \DOMElement $payment */
        $payment = $xml->getElementsByTagName('payment')[0];
        return [
            'id' => $payment->getAttribute('id'),
            'status' => $payment->getAttribute('status'),
            'message' => $payment->getAttribute('message'),
            'ref' => $payment->getAttribute('ref'),
        ];
    }
}
