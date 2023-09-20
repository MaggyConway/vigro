<?php

namespace Sntinvest\Market\Orm;

use Bitrix\Main\Entity;

class YandexProductsTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'yandex_products';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('UF_NAME'),
            new Entity\StringField('UF_SHOP_SKU'),
            new Entity\StringField('UF_MARKET_SKU'),
            new Entity\StringField('UF_MODEL_ID'),
            new Entity\StringField('UF_CATEGORY_ID'),
            new Entity\StringField('UF_COUNT'),
        );
    }

}