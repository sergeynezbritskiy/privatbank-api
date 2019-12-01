<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Response\StatementsResponse;

/**
 * Class StatementsResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class StatementsResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return StatementsResponse::class;
    }

    //tests
    public function testSuccessfulResponse()
    {
        //phpcs:ignore
        $this->content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<response version="1.0">
    <merchant>
        <id>75482</id>
        <signature>553995c5ccc8c81815b58cf6374f68f00a28bbd7</signature>
    </merchant>
    <data>
       <oper>cmt</oper>
       <info>
           <statements status="excellent" credit="0.0" debet="0.3"  >
               <statement card="5168742060221193" appcode="591969" trandate="2013-09-02" trantime="13:29:00" 
               amount="0.10 UAH" cardamount="-0.10 UAH" rest="0.95 UAH" 
               terminal="Пополнение мобильного +380139917053 через «Приват24»" description="" />
               <statement card="5168742060221193" appcode="991794" trandate="2013-09-02" trantime="13:29:00" 
               amount="0.10 UAH" cardamount="-0.10 UAH" rest="1.05 UAH" 
               terminal="Пополнение мобильного +380139917035 через «Приват24»" description="" />
               <statement card="5168742060221193" appcode="801111" trandate="2013-09-02" trantime="13:29:00" 
               amount="0.10 UAH" cardamount="-0.10 UAH" rest="1.15 UAH" 
               terminal="Пополнение мобильного +380139910008 через «Приват24»" description="" />
           </statements>
       </info>
    </data>
</response>
XML;
        $this->buildResponseMock();

        $result = $this->response->getData();
        $this->assertEquals([
            [
                'card' => '5168742060221193',
                'appcode' => '591969',
                'trandate' => '2013-09-02',
                'trantime' => '13:29:00',
                'amount' => '0.10 UAH',
                'cardamount' => '-0.10 UAH',
                'rest' => '0.95 UAH',
                'terminal' => 'Пополнение мобильного +380139917053 через «Приват24»',
                'description' => '',
            ],
            [
                'card' => '5168742060221193',
                'appcode' => '991794',
                'trandate' => '2013-09-02',
                'trantime' => '13:29:00',
                'amount' => '0.10 UAH',
                'cardamount' => '-0.10 UAH',
                'rest' => '1.05 UAH',
                'terminal' => 'Пополнение мобильного +380139917035 через «Приват24»',
                'description' => '',
            ],
            [
                'card' => '5168742060221193',
                'appcode' => '801111',
                'trandate' => '2013-09-02',
                'trantime' => '13:29:00',
                'amount' => '0.10 UAH',
                'cardamount' => '-0.10 UAH',
                'rest' => '1.15 UAH',
                'terminal' => 'Пополнение мобильного +380139910008 через «Приват24»',
                'description' => '',
            ]
        ], $result);
    }

    public function testUnknownErrorResponse()
    {
        $this->expectException(PrivatBankApiException::class);
        $this->expectExceptionMessage('error:null');
        $this->content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<response version="1.0">
    <merchant>
        <id>75482</id>
        <signature>553995c5ccc8c81815b58cf6374f68f00a28bbd7</signature>
    </merchant>
    <data>
        <oper>cmt</oper>
        <info>error:null</info>
    </data>
</response>
XML;
        $this->buildResponseMock();
    }
}
