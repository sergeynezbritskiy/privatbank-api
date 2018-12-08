<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class PaymentUkraineRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class PaymentUkraineRequestTest extends TestCase
{

    public function testBalance()
    {
        $merchantId = getenv('merchantId');
        $merchantSecret = getenv('merchantSecret');
        if (empty($merchantId) || empty($merchantSecret)) {
            $this->markTestSkipped('Merchant data not specified');
        }

        $merchant = new Merchant($merchantId, $merchantSecret);
        $this->client->setMerchant($merchant);
        $payment = $this->client->paymentUkraine([
            'payment' => '1234567',
            'b_card_or_acc' => '29244825509100',
            'amt' => '1.50',
            'ccy' => 'UAH',
            'b_name' => 'BUSINESS',
            'b_crf' => '14360570',
            'b_bic' => '305299',
            'details' => 'testUrk',
        ]);

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
