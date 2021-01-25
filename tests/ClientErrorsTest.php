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
    private PublicClient $client;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->client = new PublicClient();
    }

    /**
     * @return void
     * @throws PrivatBankApiException
     */
    public function testNotExistingRoute(): void
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
