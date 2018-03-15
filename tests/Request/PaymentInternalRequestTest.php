<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Merchant;
use SergeyNezbritskiy\PrivatBank\Request\BalanceRequest;
use SergeyNezbritskiy\PrivatBank\Request\PaymentInternalRequest;
use SergeyNezbritskiy\PrivatBank\Response\PaymentResponse;

/**
 * Class PaymentInternalRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class PaymentInternalRequestTest extends TestCase
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
        $this->request = new PaymentInternalRequest($this->client);
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
        if (empty($merchantId) || empty($merchantSecret)) {
            $this->markTestSkipped('Merchant data not specified');
        }

        $merchant = new Merchant($merchantId, $merchantSecret);
        $this->request->setMerchant($merchant);
        $result = $this->request->execute([
            'id' => '1234567',
            'b_card_or_acc' => '4627081718568608',
            'amt' => '1.50',
            'ccy' => 'UAH',
            'details' => 'test%20merch%20not%20active'
        ]);

        $this->assertInstanceOf(PaymentResponse::class, $result);

        $data = $result->toArray();

        $this->assertArrayHasKey('merchant', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('oper', $data['data']);
        $this->assertArrayHasKey('payment', $data['data']);

        $this->assertTrue(isset($data['data']['payment']));

        $payment = $data['data']['payment'];

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