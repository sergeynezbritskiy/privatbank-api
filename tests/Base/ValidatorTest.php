<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Base;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Base\AbstractRequest;
use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;
use SergeyNezbritskiy\PrivatBank\Base\HttpResponse;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Base\Validator;

/**
 * Class ValidatorTest
 * @package SergeyNezbritskiy\PrivatBank\Tests
 */
class ValidatorTest extends TestCase
{

    /**
     * @var Validator
     */
    private $validator;

    protected function setUp()
    {
        $this->validator = new Validator();
    }

    protected function tearDown()
    {
        $this->validator = null;
    }

    public function testValidResponse()
    {
        $this->assertEquals([], $this->validator->validate([], []));
    }

    /** @noinspection PhpDocMissingThrowsInspection */

    /**
     * Call protected/private method of a class.
     *
     * @param string $methodName Method name to call
     * @param array $params Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function call($methodName, array $params = [])
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $reflection = new \ReflectionClass(get_class($this->validator));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($this->validator, $params);
    }

}