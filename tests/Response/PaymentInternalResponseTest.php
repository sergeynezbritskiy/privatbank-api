<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Response\PaymentInternalResponse;

/**
 * Class PaymentInternalResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class PaymentInternalResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return PaymentInternalResponse::class;
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
        <payment id="2657374">
            <prop name="b_card_or_acc" value="4714466011522341" />
            <prop name="amt" value="10" />
            <prop name="ccy"  value="UAH" />
            <prop name="b_name" value="FIO" />
            <prop name="details" value="testVisa" />
        </payment>
    </data>
</response>
XML;

        $result = $this->response->toArray();
        $this->assertEquals([
            'merchant' => [
                'id' => '75482',
                'signature' => '553995c5ccc8c81815b58cf6374f68f00a28bbd7',
            ],
            'data' => [
                'oper' => 'cmt',
                'payment' => [[
                    'name' => 'b_card_or_acc',
                    'value' => '4714466011522341'
                ], [
                    'name' => 'amt',
                    'value' => '10'
                ], [
                    'name' => 'ccy',
                    'value' => 'UAH'
                ], [
                    'name' => 'b_name',
                    'value' => 'FIO'
                ], [
                    'name' => 'details',
                    'value' => 'testVisa'
                ]],
            ],
        ], $result);
    }

}