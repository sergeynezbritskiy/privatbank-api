<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\PublicClient;

/**
 * Class TestCasePublic
 * @package SergeyNezbritskiy\PrivatBank\Tests\Response
 */
abstract class TestCasePublic extends TestCase
{
    /**
     * @var PublicClient
     */
    protected PublicClient $client;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->client = new PublicClient();
    }
}
