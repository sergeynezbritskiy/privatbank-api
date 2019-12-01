<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Response\CheckPaymentResponse;

/**
 * Class CheckPaymentResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class CheckPaymentResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return CheckPaymentResponse::class;
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
        <payment id="1234567" status="ok" message="Исполнен" ref="P24A02509023364480" />
    </data>
</response>
XML;
        $this->buildResponseMock();

        $result = $this->response->getData();
        $this->assertEquals([
            'id' => '1234567',
            'status' => 'ok',
            'message' => 'Исполнен',
            'ref' => 'P24A02509023364480',
        ], $result);
    }
}
