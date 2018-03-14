<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractAuthorizedRequest;
use SergeyNezbritskiy\PrivatBank\Response\StatementsResponse;

/**
 * Class StatementsRequest
 *
 * Params:
 * cardNumber - required, integer
 * startDate - required, string, date format `d.m.Y`
 * endDate - required, string, date format `d.m.Y`
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/balance
 */
class StatementsRequest extends AbstractAuthorizedRequest
{

    /**
     * Body sample
     * ```xml
     *  <data>
     *      <oper>cmt</oper>
     *      <wait>0</wait>
     *      <test>0</test>
     *      <payment id="">
     *          <prop name="sd" value="11.08.2013" />
     *          <prop name="ed" value="11.09.2013" />
     *          <prop name="card" value="5168742060221193" />
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
            'startDate' => '',
            'endDate' => '',
            'cardNumber' => '',
        ], $params);

        return array_merge(parent::getBodyParams($params), [
            'payment' => [[
                'name' => 'sd',
                'value' => $params['startDate'],
            ], [
                'name' => 'ed',
                'value' => $params['endDate'],
            ], [
                'name' => 'card',
                'value' => $params['cardNumber'],
            ]]
        ]);
    }

    /**
     * @return string
     */
    protected function getRoute(): string
    {
        return 'rest_fiz';
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    protected function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new StatementsResponse($httpResponse);
    }

}