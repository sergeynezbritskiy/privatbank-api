<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;

/**
 * Class AbstractRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractRequest implements RequestInterface
{

    /**
     * @var string
     */
    protected $url = 'https://api.privatbank.ua/p24api/';

    /**
     * @return string
     */
    abstract protected function getRoute(): string;

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    abstract protected function getResponse(HttpResponseInterface $httpResponse): ResponseInterface;

}