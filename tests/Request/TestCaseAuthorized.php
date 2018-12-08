<?php declare(strict_types=1);

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
    protected function setUp()
    {
        $this->client = new AuthorizedClient();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        $this->client = null;
    }
}
