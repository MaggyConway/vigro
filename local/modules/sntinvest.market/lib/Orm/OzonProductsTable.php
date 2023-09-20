<?php

namespace Sntinvest\Market\Orm;

use Bitrix\Main\Entity;

class OzonProductsTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'ozon_products';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('UF_PRODUCTS_ID'),
            new Entity\StringField('UF_OFFER_ID'),
            new Entity\StringField('UF_SKU'),
            new Entity\StringField('UF_STOCKS_PRESENT')
        );
    }

}