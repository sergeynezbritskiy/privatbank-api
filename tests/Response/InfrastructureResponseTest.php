<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Response\InfrastructureResponse;

/**
 * Class InfrastructureResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class InfrastructureResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return InfrastructureResponse::class;
    }

    //tests
    public function testSuccessfulResponse()
    {
        $this->content = <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<atm city="Днепр" address="">
    <device type="ATM" cityRU="Днепр" cityUA="Днiпропетровськ" cityEN="Dnipropetrovsk" 
        fullAddressRu="Украина,область Днепропетровская,город Днепр,улица Малиновского,дом 34б"
        fullAddressUa="Украiна,область Днiпропетровська,мiсто Днiпропетровськ,вулиця Миру,будинок 34б" 
        fullAddressEn="Ukraine,area Dnipropetrovska,city Dnipropetrovsk,building 34b"
        placeRu="Магазин &quot;Мясо&quot;" 
        placeUa="Магазин &quot;Мясо&quot;" latitude="48.480873" longitude="35.071341">
        <tw>
            <mon>09:00 - 20:00</mon>
            <tue>09:00 - 20:00</tue>
            <wed>09:00 - 20:00</wed>
            <thu>09:00 - 20:00</thu>
            <fri>09:00 - 20:00</fri>
            <sat>09:00 - 20:00</sat>
            <sun>09:00 - 20:00</sun>
            <hol>09:00 - 20:00</hol>
        </tw>
    </device>
</atm>
XML;
        $this->buildResponseMock();

        $result = $this->response->getData();
        $this->assertEquals([
            [
                'type' => 'ATM',
                'cityRU' => 'Днепр',
                'cityUA' => 'Днiпропетровськ',
                'cityEN' => 'Dnipropetrovsk',
                'fullAddressRu' => 'Украина,область Днепропетровская,город Днепр,улица Малиновского,дом 34б',
                'fullAddressUa' => 'Украiна,область Днiпропетровська,мiсто Днiпропетровськ,вулиця Миру,будинок 34б',
                'fullAddressEn' => 'Ukraine,area Dnipropetrovska,city Dnipropetrovsk,building 34b',
                'placeRu' => 'Магазин "Мясо"',
                'placeUa' => 'Магазин "Мясо"',
                'latitude' => '48.480873',
                'longitude' => '35.071341',
                'working_time' => [
                    'mon' => '09:00 - 20:00',
                    'tue' => '09:00 - 20:00',
                    'wed' => '09:00 - 20:00',
                    'thu' => '09:00 - 20:00',
                    'fri' => '09:00 - 20:00',
                    'sat' => '09:00 - 20:00',
                    'sun' => '09:00 - 20:00',
                    'hol' => '09:00 - 20:00',
                ]
            ]
        ], $result);
    }
}
