<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Merchant;
use SergeyNezbritskiy\PrivatBank\Request\BalanceRequest;
use SergeyNezbritskiy\PrivatBank\Response\BalanceResponse;

/**
 * Class BalanceRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class BalanceRequestTest extends TestCase
{

    /**
     * @var BalanceRequest
     */
    private $request;

    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new Client();
        $this->request = new BalanceRequest($this->client);
    }

    protected function tearDown()
    {
        $this->request = null;
        $this->client = null;
    }

    public function testBalance()
    {
        $merchantId = getenv('merchantId');
        $merchantSecret = getenv('merchantSecret');
        $cardNumber = getenv('cardNumber');
        if (empty($cardNumber) || empty($merchantId) || empty($merchantSecret)) {
            $this->markTestSkipped('Merchant data not specified');
        }

        $merchant = new Merchant($merchantId, $merchantSecret);
        $result = $this->request->setMerchant($merchant)->execute([
            'cardNumber' => $cardNumber
        ]);
        $this->assertInstanceOf(BalanceResponse::class, $result);
        $data = $result->toArray();
        $this->assertArrayHasKey('merchant', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('oper', $data['data']);
        $this->assertArrayHasKey('info', $data['data']);
        $this->assertTrue(isset($data['data']['info']['cardbalance']['card']));
        $this->assertArrayHasKey('av_balance', $data['data']['info']['cardbalance']);
        $card = $data['data']['info']['cardbalance']['card'];
        $this->assertArrayHasKey('account', $card);
        $this->assertArrayHasKey('card_number', $card);
        $this->assertArrayHasKey('acc_name', $card);
        $this->assertArrayHasKey('currency', $card);
    }

}