<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\AuthorizedClient;

/**
 * Class TestCaseAuthorized
 * @package SergeyNezbritskiy\PrivatBank\Tests\Response
 */
abstract class TestCaseAuthorized extends TestCase
{
    /**
     * @var AuthorizedClient
     */
    protected AuthorizedClient $client;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->client = new AuthorizedClient();
    }
}
