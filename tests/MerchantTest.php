<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class MerchantTest
 * @package SergeyNezbritskiy\PrivatBank\tests
 */
class MerchantTest extends TestCase
{

    public function testMerchantGetter()
    {
        $id = '12345';
        $signature = md5('my_custom_string');
        $merchant = new Merchant($id, $signature);
        $this->assertEquals($id, $merchant->getId());
    }

    public function testSignatureCalculation()
    {
        $id = '12345';
        $signature = md5('my_custom_string');
        $dataString = 'another_custom_string';
        $expectedSignature = sha1(md5($dataString . $signature));
        $merchant = new Merchant($id, $signature);
        $this->assertEquals($id, $merchant->getId());
        $this->assertEquals($expectedSignature, $merchant->calculateSignature($dataString));
    }
}