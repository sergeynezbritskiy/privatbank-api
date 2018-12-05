<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractPublicRequest;
use SergeyNezbritskiy\PrivatBank\Response\OfficesResponse;

/**
 * Class OfficesRequest
 *
 * Params:
 * address - string, optional russian language
 * city - string, optional, in russian language
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/branch
 */
class OfficesRequest extends AbstractPublicRequest
{

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return 'pboffice';
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        $params = $this->getParams();
        $params = array_merge([
            'city' => '',
            'address' => ''
        ], $params);
        return [
            'city' => $params['city'],
            'address' => $params['address'],
        ];
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new OfficesResponse($httpResponse);
    }
}
