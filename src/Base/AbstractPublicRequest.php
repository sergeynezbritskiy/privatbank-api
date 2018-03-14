<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

/**
 * Class AbstractPublicRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractPublicRequest extends AbstractRequest
{

    /**
     * @param array $params
     * @return array
     */
    protected function getBodyParams(array $params = array()): array
    {
        return [];
    }

    /**
     * @return string
     */
    protected function getMethod(): string
    {
        return 'GET';
    }

}