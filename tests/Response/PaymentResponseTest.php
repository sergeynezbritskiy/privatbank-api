<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Response\PaymentResponse;

/**
 * Class PaymentInternalResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class PaymentResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return PaymentResponse::class;
    }

    //tests
    public function testSuccessfulResponse()
    {
        $this->content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<response version="1.0">
    <merchant>
        <id>75482</id>
        <signature>553995c5ccc8c81815b58cf6374f68f00a28bbd7</signature>
    </merchant>
    <data>
        <oper>cmt</oper>
        <payment id="" state="1" message="" ref="P24PKP" amt="1.5" ccy="UAH" comis="0.00" cardinfo="personified"/>
    </data>
</response>
XML;
        $this->setContent($this->content);

        $result = $this->response->toArray();
        $this->assertEquals([
            'merchant' => [
                'id' => '75482',
                'signature' => '553995c5ccc8c81815b58cf6374f68f00a28bbd7',
            ],
            'data' => [
                'oper' => 'cmt',
                'payment' => [
                    'id' => '',
                    'state' => '1',
                    'message' => '',
                    'ref' => 'P24PKP',
                    'amt' => '1.5',
                    'ccy' => 'UAH',
                    'comis' => '0.00',
                    'cardinfo' => 'personified',
                ],
            ],
        ], $result);
    }

}