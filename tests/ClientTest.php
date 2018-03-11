<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Client;

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

    public function testGetExchangeRates()
    {
        $this->assertInstanceOf(RequestInterface::class, $this->client->exchangeRates());
    }

    public function testNotSupportedMethod()
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Method notSupportedMethod not supported');
        call_user_func_array([$this->client, 'notSupportedMethod'], []);
    }

    public function testClientInterface()
    {
        $request = $this->client->exchangeRates();
        $result = $request->execute()->toArray();
        $this->assertInternalType('array', $result);
        foreach ($result as $item) {
            $this->assertArrayHasKey('ccy', $item);
            $this->assertArrayHasKey('base_ccy', $item);
            $this->assertArrayHasKey('buy', $item);
            $this->assertArrayHasKey('sale', $item);
        }
        $this->assertGreaterThan(0, count($result));
    }

}