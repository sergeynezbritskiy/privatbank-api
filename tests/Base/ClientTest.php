<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Base;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\Client;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Request;

/**
 * Class ClientTest
 */
class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->client = new Client();
    }

    /**
     * @throws PrivatBankApiException
     */
    public function testRequest()
    {
        $response = $this->client->request('pubinfo', [
            'query' => ['exchange' => '', 'coursid' => 11]
        ]);
        $this->assertInstanceOf(HttpResponseInterface::class, $response);
    }

    /**
     * @return void
     * @throws PrivatBankApiException
     */
    public function testSend(): void
    {
        $request = new Request('pubinfo', 'GET', ['exchange' => '', 'coursid' => 11]);
        $response = $this->client->send($request);
        $this->assertInstanceOf(HttpResponseInterface::class, $response);
    }

    /**
     * @return void
     */
    public function testMode(): void
    {
        $this->assertTrue($this->client->isTestMode());
        $this->assertFalse($this->client->setTestMode(false)->isTestMode());
        $this->assertTrue($this->client->setTestMode(true)->isTestMode());
    }

    /**
     * @return void
     */
    public function testTimeout(): void
    {
        $this->assertEquals(0, $this->client->getWaitTimeout());
        $this->assertEquals(10, $this->client->setWaitTimeout(10)->getWaitTimeout());
    }
}
