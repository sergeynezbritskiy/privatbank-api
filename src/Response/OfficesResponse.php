<?php declare(strict_types=1);

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
     *      <pboffice country="Украина" state="Днепропетровская" city="Днепропетровск" index="49000" address="ул Титова 29-М" phone="8(056)373-33-54, 373-33-56" email="julija.tverdokhlebovapbank.com.ua" name="Южное отд., Отделение №30"/>
     *      <pboffice country="Украина" state="Днепропетровская" city="Днепропетровск" index="49055" address="ул Титова 9" phone="8(056)771-20-83" email="elena.vasikpbank.com.ua" name="ДГРУ, Отделение N41"/>
     *  </pboffice>
     * ```
     * @return array
     */
    protected function getMap(): array
    {
        return [
            '{list} as pboffice[]' => [
                'country' => '@country',
                'state' => '@state',
                'city' => '@city',
                'index' => '@index',
                'address' => '@address',
                'phone' => '@phone',
                'email' => '@email',
                'name' => '@name',
            ]
        ];
    }

}