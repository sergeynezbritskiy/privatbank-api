<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Merchant;
use SergeyNezbritskiy\PrivatBank\Request\CheckPaymentRequest;
use SergeyNezbritskiy\PrivatBank\Response\CheckPaymentResponse;

/**
 * Class CheckPaymentRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class CheckPaymentRequestTest extends TestCase
{

    /**
     * @var CheckPaymentRequest
     */
    private $request;

    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new Client();
        $this->request = new CheckPaymentRequest($this->client);
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
            'ref' => 'P24A02509023364480'
        ]);

        $this->assertInstanceOf(CheckPaymentResponse::class, $result);

        $payment = $result->toArray();

        $this->assertArrayHasKey('id', $payment);
        $this->assertArrayHasKey('status', $payment);
        $this->assertArrayHasKey('message', $payment);
        $this->assertArrayHasKey('ref', $payment);

    }

}