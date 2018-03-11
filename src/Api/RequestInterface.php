<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Api;

/**
 * Interface RequestInterface
 * @package SergeyNezbritskiy\PrivatBank\Api
 */
interface RequestInterface
{

    /**
     * @param array $params
     * @return ResponseInterface
     */
    public function execute(array $params = array()): ResponseInterface;

}