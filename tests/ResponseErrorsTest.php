<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Base\HttpResponse;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\PublicClient;

/**
 * Class ResponseErrorsTest
 * @package SergeyNezbritskiy\PrivatBank\Tests
 */
class ResponseErrorsTest extends TestCase
{

    /**
     * @var PublicClient
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = new PublicClient();
    }

    protected function tearDown(): void
    {
        $this->client = null;
    }

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testNotExistingRoute()
    {
        $this->expectException(PrivatBankApiException::class);
        $this->expectExceptionCode(404);
        $this->client->request('not_existing_route', [
            'query' => [],
            'body' => '',
            'method' => 'GET',
        ]);
    }

    /** @noinspection PhpDocMissingThrowsInspection */

    /**
     * Call protected/private method of a class.
     *
     * @param string $methodName Method name to call
     * @param array $params Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function call($methodName, array $params = [])
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $reflection = new \ReflectionClass(get_class($this->client));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($this->client, $params);
    }
}
