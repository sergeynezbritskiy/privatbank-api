<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Base;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Request;

/**
 * Class ClientTest
 */
class ClientTest extends TestCase
{

    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new Client();
    }

    protected function tearDown()
    {
        $this->client = null;
    }

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testRequest()
    {
        $response = $this->client->request('pubinfo', [
            'query' => ['exchange' => '', 'coursid' => 11]
        ]);
        $this->assertInstanceOf(HttpResponseInterface::class, $response);
    }

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testSend()
    {
        $request = new Request('pubinfo', 'GET', ['exchange' => '', 'coursid' => 11]);
        $response = $this->client->send($request);
        $this->assertInstanceOf(HttpResponseInterface::class, $response);
    }

    public function testMode()
    {
        $this->assertTrue($this->client->isTestMode());
        $this->assertFalse($this->client->setTestMode(false)->isTestMode());
        $this->assertTrue($this->client->setTestMode(true)->isTestMode());
    }

    public function testTimeout()
    {
        $this->assertEquals(0, $this->client->getWaitTimeout());
        $this->assertEquals(10, $this->client->setWaitTimeout(10)->getWaitTimeout());
    }
}
