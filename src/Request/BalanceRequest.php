<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractAuthorizedRequest;
use SergeyNezbritskiy\PrivatBank\Response\BalanceResponse;

/**
 * Class BalanceRequest
 *
 * Params:
 * cardNumber - required, integer
 * country - optional, string
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/balance
 */
class BalanceRequest extends AbstractAuthorizedRequest
{

    /**
     * Body sample
     * ```xml
     *  <data>
     *      <oper>cmt</oper>
     *      <wait>0</wait>
     *      <test>0</test>
     *      <payment id="">
     *          <prop name="cardnum" value="5168742060221193" />
     *          <prop name="country" value="UA" />
     *      </payment>
     *  </data>
     * ```
     * @return array
     */
    protected function getBodyMap(): array
    {
        return [
            'oper',
            'wait',
            'test',
            'payment' => [
                'children' => [
                    'prop[]' => [
                        'dataProvider' => 'payment',
                        'attributes' => ['name', 'value'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param array $params
     * @return array
     */
    protected function getBodyParams(array $params = []): array
    {
        $params = array_merge([
            'country' => 'UA',
            'cardNumber' => '',
        ], $params);

        return array_merge(parent::getBodyParams($params), [
            'payment' => [[
                'name' => 'cardnum',
                'value' => $params['cardNumber'],
            ], [
                'name' => 'country',
                'value' => $params['country'],
            ]]
        ]);
    }

    /**
     * @return string
     */
    protected function getRoute(): string
    {
        return 'balance';
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    protected function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new BalanceResponse($httpResponse);
    }

}