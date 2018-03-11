<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class InfrastructureResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class InfrastructureResponse extends AbstractResponse
{

    /**
     * Response Sample
     * ```xml
     *  <?xml version="1.0" encoding="UTF-8" standalone="yes"?>
     *  <atm city="Днепропетровск" address="">
     *      <device type="ATM" cityRU="Днепропетровск" cityUA="Днiпропетровськ" cityEN="Dnipropetrovsk" fullAddressRu="Украина,область Днепропетровская,город Днепропетровск,улица Малиновского,дом 34б" fullAddressUa="Украiна,область Днiпропетровська,мiсто Днiпропетровськ,вулиця Малиновського,будинок 34б" fullAddressEn="Ukraine,area Dnipropetrovska,city Dnipropetrovsk,building 34b" placeRu="Магазин &quot;Мясо&quot;" placeUa="Магазин &quot;Мясо&quot;" latitude="48.480873" longitude="35.071341">
     *          <tw>
     *              <mon>09:00 - 20:00</mon>
     *              <tue>09:00 - 20:00</tue>
     *              <wed>09:00 - 20:00</wed>
     *              <thu>09:00 - 20:00</thu>
     *              <fri>09:00 - 20:00</fri>
     *              <sat>09:00 - 20:00</sat>
     *              <sun>09:00 - 20:00</sun>
     *              <hol>09:00 - 20:00</hol>
     *          </tw>
     *      </device>
     *  </atm>
     * ```
     * @return array
     */
    protected function getMap(): array
    {
        return [
            '{list} as device[]' => [
                'type' => '@type',
                'cityRU' => '@cityRU',
                'cityUA' => '@cityUA',
                'cityEN' => '@cityEN',
                'fullAddressRu' => '@fullAddressRu',
                'fullAddressUa' => '@fullAddressUa',
                'fullAddressEn' => '@fullAddressEn',
                'placeRu' => '@placeRu',
                'placeUa' => '@placeUa',
                'latitude' => '@latitude',
                'longitude' => '@longitude',
                'working_time as tw' => [
                    'mon' => 'mon',
                    'tue' => 'tue',
                    'wed' => 'wed',
                    'thu' => 'thu',
                    'fri' => 'fri',
                    'sat' => 'sat',
                    'sun' => 'sun',
                    'hol' => 'hol',
                ]
            ]
        ];
    }

}