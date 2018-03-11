<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank;

use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;

/**
 * Class Client
 * @package SergeyNezbritskiy\PrivatBank
 * @method RequestInterface exchangeRates(array $params = [])
 */
class Client
{

    /**
     * @param string $name
     * @param array $arguments
     * @return RequestInterface
     * @throws \ErrorException
     */
    public function __call($name, $arguments)
    {
        $class = '\\SergeyNezbritskiy\\PrivatBank\\Request\\' . ucfirst($name) . 'Request';
        if (class_exists($class)) {
            return new $class(...$arguments);
        } else {
            throw new \ErrorException('Method ' . $name . ' not supported');
        }
    }

}