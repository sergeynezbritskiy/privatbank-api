<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Api;

use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;

/**
 * Interface RequestInterface
 * @package SergeyNezbritskiy\PrivatBank\Api
 */
interface RequestInterface
{

    /**
     * @param array $params
     * @return ResponseInterface
     * @throws PrivatBankApiException
     */
    public function execute(array $params = array()): ResponseInterface;
}
