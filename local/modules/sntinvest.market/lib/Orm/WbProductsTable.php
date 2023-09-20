<?php

namespace Sntinvest\Market\Orm;

use Bitrix\Main\Entity;

class WbProductsTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'wb_products';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('UF_VENDOR_ID'),
            new Entity\StringField('UF_NMID'),
            new Entity\DateTimeField('UF_CREATED'),
            new Entity\DateTimeField('UF_UPDATE'),
        );
    }

}