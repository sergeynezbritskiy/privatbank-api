<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Response\OfficesResponse;

/**
 * Class OfficesResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class OfficesResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return OfficesResponse::class;
    }

    //tests
    public function testSuccessfulResponse()
    {
        $this->content = <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<pboffice>
    <pboffice country="Украина" state="Днепропетровская" city="Днепр" index="49000" address="ул Титова 29-М" 
    phone="8(056)373-33-54, 373-33-56" email="julija.tverdokhlebovapbank.com.ua" name="Южное отд., Отделение №30"/>
    <pboffice country="Украина" state="Днепропетровская" city="Днепр" index="49055" address="ул Титова 9" 
    phone="8(056)771-20-83" email="elena.vasikpbank.com.ua" name="ДГРУ, Отделение N41"/>
</pboffice>
XML;
        $this->buildResponseMock();

        $result = $this->response->getData();
        $this->assertEquals([
            [
                'country' => 'Украина',
                'state' => 'Днепропетровская',
                'city' => 'Днепр',
                'index' => '49000',
                'address' => 'ул Титова 29-М',
                'phone' => '8(056)373-33-54, 373-33-56',
                'email' => 'julija.tverdokhlebovapbank.com.ua',
                'name' => 'Южное отд., Отделение №30',
            ],
            [
                'country' => 'Украина',
                'state' => 'Днепропетровская',
                'city' => 'Днепр',
                'index' => '49055',
                'address' => 'ул Титова 9',
                'phone' => '8(056)771-20-83',
                'email' => 'elena.vasikpbank.com.ua',
                'name' => 'ДГРУ, Отделение N41',
            ]
        ], $result);
    }
}
