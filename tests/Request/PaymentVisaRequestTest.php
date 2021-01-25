<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class PaymentVisaRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class PaymentVisaRequestTest extends TestCaseAuthorized
{
    /**
     * @return void
     * @throws PrivatBankApiException
     */
    public function testBalance(): void
    {
        $merchantId = getenv('merchantId');
        $merchantSecret = getenv('merchantSecret');
        if (empty($merchantId) || empty($merchantSecret)) {
            $this->markTestSkipped('Merchant data not specified');
        }

        $merchant = new Merchant($merchantId, $merchantSecret);
        $this->client->setMerchant($merchant);
        $payment = $this->client->paymentVisa(
            '1234567',
            '4714466011522341',
            1.50,
            'Sergey Nez',
            'UAH',
            'test%20merch%20not%20active'
        );

        $this->assertArrayHasKey('id', $payment);
        $this->assertArrayHasKey('state', $payment);
        $this->assertArrayHasKey('message', $payment);
        $this->assertArrayHasKey('ref', $payment);
        $this->assertArrayHasKey('amt', $payment);
        $this->assertArrayHasKey('ccy', $payment);
        $this->assertArrayHasKey('comis', $payment);
        $this->assertArrayHasKey('cardinfo', $payment);
    }
}
