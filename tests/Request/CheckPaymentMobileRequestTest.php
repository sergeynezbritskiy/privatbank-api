<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class CheckPaymentMobileRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class CheckPaymentMobileRequestTest extends TestCaseAuthorized
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
        $data = $this->client->checkPaymentMobile('1234567');

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('state', $data);
        $this->assertArrayHasKey('message', $data);
    }
}
