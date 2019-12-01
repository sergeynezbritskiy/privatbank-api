<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class CheckPaymentMobileResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class CheckPaymentMobileResponse extends AbstractResponse
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
     *          <payment id="1234567" state="ok" message="Исполнен" />
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
        ];
    }
}
