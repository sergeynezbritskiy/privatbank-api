<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractPublicRequest;
use SergeyNezbritskiy\PrivatBank\Response\InfrastructureResponse;

/**
 * Class InfrastructureRequest
 *
 * Params:
 * type - string, required, `atm` or `tso`, see class constants
 * address - string, optional russian language
 * city - string, optional, in russian language
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/atm
 * @see https://api.privatbank.ua/#p24/terminals
 */
class InfrastructureRequest extends AbstractPublicRequest
{

    const TYPE_ATM = 'atm';
    const TYPE_TERMINAL = 'tso';

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return 'infrastructure';
    }

    /**
     * @param array $params
     * @return array
     */
    public function getQueryParams(array $params = []): array
    {
        $params = array_merge([
            'city' => '',
            'address' => '',
            'type' => '',//`atm` or `tso`
        ], $params);
        return [
            $params['type'] => '',
            'city' => $params['city'],
            'address' => $params['address'],
        ];
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    public function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new InfrastructureResponse($httpResponse);
    }

}