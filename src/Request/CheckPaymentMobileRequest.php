<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractAuthorizedRequest;
use SergeyNezbritskiy\PrivatBank\Response\CheckPaymentMobileResponse;

/**
 * Class CheckPaymentMobileRequest
 *
 * Params:
 * paymentId - required, integer
 *
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/mobile
 */
class CheckPaymentMobileRequest extends AbstractAuthorizedRequest
{

    /**
     * Body sample
     * ```xml
     *  <data>
     *      <oper>cmt</oper>
     *      <wait>0</wait>
     *      <test>0</test>
     *      <oper>cmt</oper>
     *      <payment>
     *          <prop name="id" value="1234567" />
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
                'attributes' => ['id'],
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
            'payment' => '',
            'ref' => '',
        ], $params);

        return array_merge(parent::getBodyParams($params), [
            'id' => $params['paymentId'],
            'payment' => [[
                'name' => 'id',
                'value' => $params['paymentId'],
            ]]
        ]);
    }

    /**
     * @return string
     */
    protected function getRoute(): string
    {
        return 'check_directfill';
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    protected function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new CheckPaymentMobileResponse($httpResponse);
    }

}