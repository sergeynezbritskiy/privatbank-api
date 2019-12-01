<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Api;

/**
 * Class ResponseInterface
 * @package SergeyNezbritskiy\PrivatBank\Api
 */
interface ResponseInterface
{

    /**
     * @return array
     */
    public function getData(): array;
}
