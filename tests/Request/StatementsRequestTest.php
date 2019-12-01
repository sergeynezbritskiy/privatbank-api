<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class StatementsRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class StatementsRequestTest extends TestCaseAuthorized
{

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testBalance()
    {
        $merchantId = getenv('merchantId');
        $merchantSecret = getenv('merchantSecret');
        $card = getenv('cardNumber');
        $startDate = getenv('startDate');
        $endDate = getenv('endDate');
        if (empty($card) || empty($merchantId) || empty($merchantSecret) || empty($startDate) || empty($endDate)) {
            $this->markTestSkipped('Merchant data not specified');
        }
        $merchantId = new Merchant($merchantId, $merchantSecret);
        $this->client->setMerchant($merchantId);
        $statements = $this->client->statements($card, $startDate, $endDate);

        $this->assertGreaterThan(0, count($statements));

        foreach ($statements as $cardData) {
            $this->assertArrayHasKey('card', $cardData);
            $this->assertArrayHasKey('appcode', $cardData);
            $this->assertArrayHasKey('trandate', $cardData);
            $this->assertArrayHasKey('trantime', $cardData);
            $this->assertArrayHasKey('amount', $cardData);
            $this->assertArrayHasKey('cardamount', $cardData);
            $this->assertArrayHasKey('rest', $cardData);
            $this->assertArrayHasKey('terminal', $cardData);
            $this->assertArrayHasKey('description', $cardData);
            break;
        }
    }
}
