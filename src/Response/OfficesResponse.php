<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class OfficesResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class OfficesResponse extends AbstractResponse
{

    /**
     * Response Sample
     * ```xml
     *  <?xml version="1.0" encoding="UTF-8" standalone="yes"?>
     *  <pboffice>
     *      <pboffice country="Украина" state="Днепропетровская" city="Днепр" index="49000"
     *              address="ул Титова 29-М" phone="8(056)373-33-54, 373-33-56"
     *              email="julija.tverdokhlebovapbank.com.ua" name="Южное отд., Отделение №30"/>
     *      <pboffice country="Украина" state="Днепропетровская" city="Днепр" index="49055"
     *              address="ул Титова 9" phone="8(056)771-20-83"
     *              email="elena.vasikpbank.com.ua" name="ДГРУ, Отделение N41"/>
     *  </pboffice>
     * ```
     * @return array
     */
    public function getData(): array
    {
        $xml = $this->getXmlContent();
        /** @var \DOMNodeList $offices */
        $offices = $xml->getElementsByTagName('pboffice');
        $result = [];
        /** @var \DOMElement $office */
        foreach ($offices as $office) {
            if ($office->getNodePath() === '/pboffice') {
                continue;
            }
            $result[] = [
                'country' => $office->getAttribute('country'),
                'state' => $office->getAttribute('state'),
                'city' => $office->getAttribute('city'),
                'index' => $office->getAttribute('index'),
                'address' => $office->getAttribute('address'),
                'phone' => $office->getAttribute('phone'),
                'email' => $office->getAttribute('email'),
                'name' => $office->getAttribute('name'),
            ];
        }
        return $result;
    }
}
