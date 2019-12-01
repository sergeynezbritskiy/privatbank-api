<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class PaymentMobileRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class PaymentMobileRequestTest extends TestCaseAuthorized
{

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testBalance()
    {
        $merchantId = getenv('merchantId');
        $merchantSecret = getenv('merchantSecret');
        if (empty($merchantId) || empty($merchantSecret)) {
            $this->markTestSkipped('Merchant data not specified');
        }

        $merchant = new Merchant($merchantId, $merchantSecret);
        $this->client->setMerchant($merchant);
        $payment = $this->client->paymentMobile('1234567', '%2B380632285977', 1.50);

        $this->assertArrayHasKey('id', $payment);
        $this->assertArrayHasKey('state', $payment);
        $this->assertArrayHasKey('auto_id', $payment);
        $this->assertArrayHasKey('message', $payment);
        $this->assertArrayHasKey('ref', $payment);
        $this->assertArrayHasKey('amt', $payment);
        $this->assertArrayHasKey('ccy', $payment);
        $this->assertArrayHasKey('comis', $payment);
        $this->assertArrayHasKey('code', $payment);
    }
}
