<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Client;

/**
 * Class TestCase
 * @package SergeyNezbritskiy\PrivatBank\Tests\Response
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->client = new Client();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        $this->client = null;
    }
}
