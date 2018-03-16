<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Merchant;
use SergeyNezbritskiy\PrivatBank\Request\StatementsRequest;
use SergeyNezbritskiy\PrivatBank\Response\StatementsResponse;

/**
 * Class StatementsRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class StatementsRequestTest extends TestCase
{

    /**
     * @var StatementsRequest
     */
    private $request;

    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new Client();
        $this->request = new StatementsRequest($this->client);
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
        $startDate = getenv('startDate');
        $endDate = getenv('endDate');
        if (empty($cardNumber) || empty($merchantId) || empty($merchantSecret) || empty($startDate) || empty($endDate)) {
            $this->markTestSkipped('Merchant data not specified');
        }

        $merchant = new Merchant($merchantId, $merchantSecret);
        $this->request->setMerchant($merchant);
        $result = $this->request->execute([
            'cardNumber' => $cardNumber,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        $this->assertInstanceOf(StatementsResponse::class, $result);

        $data = $result->toArray();

        $this->assertArrayHasKey('merchant', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('oper', $data['data']);
        $this->assertArrayHasKey('info', $data['data']);

        $this->assertTrue(isset($data['data']['info']['statements']));

        $statements = $data['data']['info']['statements'];
        $this->assertGreaterThan(0, count($statements));
        foreach ($statements as $card) {
            $this->assertArrayHasKey('card', $card);
            $this->assertArrayHasKey('appcode', $card);
            $this->assertArrayHasKey('trandate', $card);
            $this->assertArrayHasKey('amount', $card);
            $this->assertArrayHasKey('cardamount', $card);
            $this->assertArrayHasKey('rest', $card);
            $this->assertArrayHasKey('terminal', $card);
            $this->assertArrayHasKey('description', $card);
            break;
        }

    }

}