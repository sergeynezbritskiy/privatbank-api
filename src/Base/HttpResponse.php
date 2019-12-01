<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;

/**
 * Class HttpResponse
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
class HttpResponse implements HttpResponseInterface
{

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $phrase;

    /**
     * HttpResponse constructor.
     * @param string $content
     * @param int $code
     * @param string $phrase
     */
    public function __construct(string $content, int $code, string $phrase)
    {
        $this->content = $content;
        $this->code = $code;
        $this->phrase = $phrase;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->phrase;
    }
}
