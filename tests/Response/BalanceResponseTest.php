<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Response\BalanceResponse;

/**
 * Class BalanceResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class BalanceResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return BalanceResponse::class;
    }

    //tests
    public function testSuccessfulResponse()
    {
        $this->content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<response version="1.0">
    <merchant>
        <id>111111</id>
        <signature>546c391f98572a122abab1c0948c87fe7e6ed421</signature>
    </merchant>
    <data>
        <oper>cmt</oper>
        <info>
            <cardbalance>
                <card>
                    <account>4111111111111111</account>
                    <card_number>4111111111111111</card_number>
                    <acc_name>Карта для выплат</acc_name>
                    <acc_type>CM</acc_type>
                    <currency>UAH</currency>
                    <card_type>Карта для выплат</card_type>
                    <main_card_number>4111111111111111</main_card_number>
                    <card_stat>NORM</card_stat>
                    <src>M</src>
                </card>
                <av_balance>0.95</av_balance>
                <bal_date>11.09.13 15:56</bal_date>
                <bal_dyn>E</bal_dyn>
                <balance>0.95</balance>
                <fin_limit>0.00</fin_limit>
                <trade_limit>0.00</trade_limit>
            </cardbalance>
        </info>
    </data>
</response>
XML;
        $this->buildResponseMock();
        $result = $this->response->getData();
        $this->assertEquals([
            'card' => [
                'account' => '4111111111111111',
                'card_number' => '4111111111111111',
                'acc_name' => 'Карта для выплат',
                'acc_type' => 'CM',
                'currency' => 'UAH',
                'card_type' => 'Карта для выплат',
                'main_card_number' => '4111111111111111',
                'card_stat' => 'NORM',
                'src' => 'M',
            ],
            'av_balance' => '0.95',
            'bal_date' => '11.09.13 15:56',
            'bal_dyn' => 'E',
            'balance' => '0.95',
            'fin_limit' => '0.00',
            'trade_limit' => '0.00',
        ], $result);
    }
}
