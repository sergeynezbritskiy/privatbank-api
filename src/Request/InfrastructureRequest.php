<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractPublicRequest;
use SergeyNezbritskiy\PrivatBank\Base\Validator;
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

    public const TYPE_ATM = 'atm';
    public const TYPE_TERMINAL = 'tso';

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return 'infrastructure';
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        $params = $this->getParams();
        return [
            $params['type'] => '',
            'address' => $params['address'],
            'city' => $params['city'],
        ];
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new InfrastructureResponse($httpResponse);
    }

    /**
     * @return array
     */
    protected function getValidationRules(): array
    {
        return [
            [['city', 'address', 'type'], Validator::TYPE_DEFAULT, 'value' => ''],
        ];
    }
}
