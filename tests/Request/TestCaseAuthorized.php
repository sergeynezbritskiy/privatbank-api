<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\AuthorizedClient;

/**
 * Class TestCaseAuthorized
 * @package SergeyNezbritskiy\PrivatBank\Tests\Response
 */
abstract class TestCaseAuthorized extends \PHPUnit\Framework\TestCase
{

    /**
     * @var AuthorizedClient
     */
    protected $client;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->client = new AuthorizedClient();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        $this->client = null;
    }
}
