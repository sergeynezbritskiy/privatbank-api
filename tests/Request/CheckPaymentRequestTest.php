<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class CheckPaymentRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class CheckPaymentRequestTest extends TestCaseAuthorized
{

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testCheckPaymentValid()
    {
        $merchantId = getenv('merchantId');
        $merchantSecret = getenv('merchantSecret');
        if (empty($merchantId) || empty($merchantSecret)) {
            $this->markTestSkipped('Merchant data not specified');
        }

        $merchant = new Merchant($merchantId, $merchantSecret);
        $this->client->setMerchant($merchant);
        $payment = $this->client->checkPayment('1234567', 'P24A02509023364480');

        $this->assertArrayHasKey('id', $payment);
        $this->assertArrayHasKey('status', $payment);
        $this->assertArrayHasKey('message', $payment);
        $this->assertArrayHasKey('ref', $payment);
    }

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testCheckPaymentInvalid()
    {
        $merchantId = getenv('merchantId');
        $merchantSecret = getenv('merchantSecret');
        if (empty($merchantId) || empty($merchantSecret)) {
            $this->markTestSkipped('Merchant data not specified');
        }
        $merchant = new Merchant($merchantId, $merchantSecret);
        $this->client->setMerchant($merchant);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Either id or ref should be passed');
        $this->client->checkPayment();
    }
}
