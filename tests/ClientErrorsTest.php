<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Base\HttpResponse;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\PublicClient;

/**
 * Class ClientErrorsTest
 * @package SergeyNezbritskiy\PrivatBank\Tests
 */
class ClientErrorsTest extends TestCase
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
}
