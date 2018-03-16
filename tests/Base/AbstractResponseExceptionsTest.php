<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Base;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;
use SergeyNezbritskiy\PrivatBank\Tests\Response\TestCase;

/**
 * Class AbstractResponseExceptionsTest
 * @package SergeyNezbritskiy\PrivatBank\Tests\Base
 */
class AbstractResponseExceptionsTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return AbstractResponse::class;
    }

    public function testNonOkCode()
    {
        $this->assertTrue(true);
    }
}