<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class PaymentUkraineRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class PaymentUkraineRequestTest extends TestCaseAuthorized
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
        $payment = $this->client->paymentUkraine(
            '1234567',
            '29244825509100',
            1.50,
            'UAH',
            'BUSINESS',
            '14360570',
            '305299',
            'testUrk'
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
