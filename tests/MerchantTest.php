<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class MerchantTest
 * @package SergeyNezbritskiy\PrivatBank\tests
 */
class MerchantTest extends TestCase
{
    /**
     * @return void
     */
    public function testMerchantGetter(): void
    {
        $merchantId = '12345';
        $signature = md5('my_custom_string');
        $merchant = new Merchant($merchantId, $signature);
        $this->assertEquals($merchantId, $merchant->getMerchantId());
    }

    /**
     * @return void
     */
    public function testSignatureCalculation(): void
    {
        $merchantId = '12345';
        $signature = md5('my_custom_string');
        $dataString = 'another_custom_string';
        $expectedSignature = sha1(md5($dataString . $signature));
        $merchant = new Merchant($merchantId, $signature);
        $this->assertEquals($merchantId, $merchant->getMerchantId());
        $this->assertEquals($expectedSignature, $merchant->calculateSignature($dataString));
    }
}
