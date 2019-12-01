<?php

declare(strict_types=1);

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
     *  <atm city="Днепр" address="">
     *      <device type="ATM" cityRU="Днепр" cityUA="Днiпропетровськ" cityEN="Dnipropetrovsk"
     *              fullAddressRu="Украина,область Днепропетровская,город Днепр,улица Малиновского,дом 34б"
     *              fullAddressUa="Украiна,область Днiпропетровська,мiсто Днiпропетровськ,вулиця Миру,будинок 34б"
     *              fullAddressEn="Ukraine,area Dnipropetrovska,city Dnipropetrovsk,building 34b"
     *              placeRu="Магазин &quot;Мясо&quot;" placeUa="Магазин &quot;Мясо&quot;"
     *              latitude="48.480873" longitude="35.071341">
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
    public function getData(): array
    {
        $xml = $this->getXmlContent();
        /** @var \DOMNodeList $devices */
        $devices = $xml->getElementsByTagName('device');
        $result = [];
        /** @var \DOMElement $deviceXml */
        foreach ($devices as $deviceXml) {
            /** @var \DOMElement $workingTimeXml */
            $workingTimeXml = $deviceXml->getElementsByTagName('tw')[0];
            $children = $workingTimeXml->childNodes;
            $workingTime = [];
            /** @var \DOMElement $dayOfWeek */
            foreach ($children as $dayOfWeek) {
                if ($dayOfWeek instanceof \DOMText) {
                    continue;
                }
                $workingTime[$dayOfWeek->tagName] = $dayOfWeek->textContent;
            }

            $result[] = [
                'type' => $deviceXml->getAttribute('type'),
                'cityRU' => $deviceXml->getAttribute('cityRU'),
                'cityUA' => $deviceXml->getAttribute('cityUA'),
                'cityEN' => $deviceXml->getAttribute('cityEN'),
                'fullAddressRu' => $deviceXml->getAttribute('fullAddressRu'),
                'fullAddressUa' => $deviceXml->getAttribute('fullAddressUa'),
                'fullAddressEn' => $deviceXml->getAttribute('fullAddressEn'),
                'placeRu' => $deviceXml->getAttribute('placeRu'),
                'placeUa' => $deviceXml->getAttribute('placeUa'),
                'latitude' => $deviceXml->getAttribute('latitude'),
                'longitude' => $deviceXml->getAttribute('longitude'),
                'working_time' => $workingTime,
            ];
        }
        return $result;
    }
}
