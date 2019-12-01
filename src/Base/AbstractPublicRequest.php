<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

/**
 * Class AbstractPublicRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractPublicRequest extends AbstractRequest
{

    /**
     * @return string
     */
    protected function getMethod(): string
    {
        return 'GET';
    }

    /**
     * @param array $params
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getBody(array $params = []): string
    {
        return '';
    }

    /**
     * @return array
     */
    protected function getBodyParams(): array
    {
        return [];
    }
}
