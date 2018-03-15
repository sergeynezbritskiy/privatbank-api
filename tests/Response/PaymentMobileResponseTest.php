<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Response\PaymentMobileResponse;

/**
 * Class PaymentMobileResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class PaymentMobileResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return PaymentMobileResponse::class;
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
        <payment id="1234567" state="ok" message="Исполнен" />
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
                'payment' => [
                    'id' => '1234567',
                    'state' => 'ok',
                    'message' => 'Исполнен',
                ],
            ],
        ], $result);
    }

}