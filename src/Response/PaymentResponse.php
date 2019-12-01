<?php

declare(strict_types=1);

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
     *          <payment id="" state="1" message="" ref="P24PKP"
     *                   amt="1.5" ccy="UAH" comis="0.00" cardinfo="personified"/>
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
            'state' => $payment->getAttribute('state'),
            'message' => $payment->getAttribute('message'),
            'ref' => $payment->getAttribute('ref'),
            'amt' => $payment->getAttribute('amt'),
            'ccy' => $payment->getAttribute('ccy'),
            'comis' => $payment->getAttribute('comis'),
            'cardinfo' => $payment->getAttribute('cardinfo'),
        ];
    }
}
