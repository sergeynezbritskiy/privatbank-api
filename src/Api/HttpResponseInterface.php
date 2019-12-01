<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Api;

/**
 * Interface HttpResponseInterface
 * @package SergeyNezbritskiy\PrivatBank\Api
 */
interface HttpResponseInterface
{

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return string
     */
    public function getReasonPhrase(): string;
}
