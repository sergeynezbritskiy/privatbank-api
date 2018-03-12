<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Merchant;
use SergeyNezbritskiy\PrivatBank\Request\BalanceRequest;
use SergeyNezbritskiy\PrivatBank\Response\BalanceResponse;

/**
 * Class BalanceRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class BalanceRequestTest extends TestCase
{

    /**
     * @var BalanceRequest
     */
    private $request;

    protected function setUp()
    {
        $this->request = new BalanceRequest();
    }

    protected function tearDown()
    {
        $this->request = null;
    }

    public function testBalance()
    {
        $this->markTestSkipped();
        $result = $this->request
            ->setMerchant(new Merchant('1', 'asdf'))
            ->execute([

            ]);
        $this->assertInstanceOf(BalanceResponse::class, $result);
        $data = $result->toArray();
        $this->assertGreaterThan(0, count($data));
        foreach ($data as $item) {
            $this->assertArrayHasKey('country', $item);
            $this->assertArrayHasKey('state', $item);
            $this->assertArrayHasKey('city', $item);
            $this->assertArrayHasKey('index', $item);
            $this->assertArrayHasKey('address', $item);
            $this->assertArrayHasKey('phone', $item);
            $this->assertArrayHasKey('email', $item);
            $this->assertArrayHasKey('name', $item);
            break;
        }
    }

}