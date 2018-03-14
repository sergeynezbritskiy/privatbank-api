<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
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

    protected function setUp()
    {
        $this->request = new BalanceRequest();
    }

    protected function tearDown()
    {
        $this->request = null;
    }

    public function testBalance()
    {
        $merchantId = getenv('merchantId');
        $merchantSecret = getenv('merchantSecret');
        $cardNumber = getenv('cardNumber');
        $result = $this->request
            ->setMerchant(new Merchant($merchantId, $merchantSecret))
            ->execute([
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