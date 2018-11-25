<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Merchant;
use SergeyNezbritskiy\PrivatBank\Request\PaymentInternalRequest;
use SergeyNezbritskiy\PrivatBank\Response\PaymentResponse;

/**
 * Class PaymentInternalRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class PaymentInternalRequestTest extends TestCase
{

    /**
     * @var PaymentInternalRequest
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
        $this->request->setMerchant($merchant);
        $result = $this->request->execute([
            'payment' => '1234567',
            'b_card_or_acc' => '4627081718568608',
            'amt' => '1.50',
            'ccy' => 'UAH',
            'details' => 'test%20merch%20not%20active'
        ]);

        $this->assertInstanceOf(PaymentResponse::class, $result);

        $payment = $result->getData();

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