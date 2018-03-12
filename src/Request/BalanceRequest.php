<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractAuthorizedRequest;
use SergeyNezbritskiy\PrivatBank\Response\BalanceResponse;

/**
 * Class BalanceRequest
 * @package SergeyNezbritskiy\PrivatBank\Request
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
     * @param array $params
     * @return array
     */
    protected function getBodyMap(array $params = []): array
    {
        return [
            'data' => [
                'children' => [
                    'oper',
                    'wait',
                    'test',
                    'payment' => [
                        'children' => [
                            'prop[]' => [
                                'dataProvider' => 'payment',
                                'attributes' => ['name', 'value'],
                            ],
                        ]
                    ],
                ],
            ],
        ];
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