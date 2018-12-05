<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Merchant;
use SergeyNezbritskiy\PrivatBank\Request\CheckPaymentMobileRequest;
use SergeyNezbritskiy\PrivatBank\Response\CheckPaymentMobileResponse;

/**
 * Class CheckPaymentMobileRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class CheckPaymentMobileRequestTest extends TestCase
{

    /**
     * @var CheckPaymentMobileRequest
     */
    private $request;

    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new Client();
        $this->request = new CheckPaymentMobileRequest($this->client);
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
            'paymentId' => '1234567',
        ]);

        $this->assertInstanceOf(CheckPaymentMobileResponse::class, $result);

        $data = $result->getData();

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('state', $data);
        $this->assertArrayHasKey('message', $data);
    }
}
