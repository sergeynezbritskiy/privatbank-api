<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\PublicClient;

/**
 * Class TestCasePublic
 * @package SergeyNezbritskiy\PrivatBank\Tests\Response
 */
abstract class TestCasePublic extends \PHPUnit\Framework\TestCase
{

    /**
     * @var PublicClient
     */
    protected $client;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->client = new PublicClient();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        $this->client = null;
    }
}
