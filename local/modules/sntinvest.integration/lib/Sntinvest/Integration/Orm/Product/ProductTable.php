<?php

/*
 * This file is part of bus-stage.sntinvest.ru project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Orm\Product;

use Bitrix\Catalog\ProductTable as BX_ProductTable;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\ORM\Query\Join;

/**
 * Description of Company
 *
 * @author dimay
 */
class ProductTable extends BX_ProductTable
{
    private static $field_xml_id = 'XML_ID';
    
    /**
     * Override parent method to get object
     * @return string
     */
    public static function getObjectClass()
    {
        return EO_Product::class;
    }
    
    /**
     * Override parent method to get collection
     * @return string
     */
    public static function getCollectionClass(){
        return EO_Product_Collection::class;
    }
    
    /**
     * Override parent method to get map
     * @return array
     */
    public static function getMap()
    {
        $arMap = parent::getMap();
        
        return array_merge($arMap ?? [], [
            (new Reference(
                   'ELEMENT',
                   ElementTable::class,
                   Join::on('this.ID', 'ref.ID')
               ))
        ]);
    }
    
    /**
     * Getting a new object
     * @return \Sntinvest\Integration\Orm\Company\Company
     */
    public static function newObject()
    {
        $class = static::getObjectClass();
        return new $class();
    }
    
    /**
     * 
     * @param type $xmlId
     */
    public static function findOrCreated($xmlId)
    {
        $item = static::find($xmlId);
        
        if (is_null($item))
        {
            $item = static::newObject();
        }
        
        return $item;
    }
    
    /**
     * 
     * @param type $xmlId
     */
    public static function find($xmlId)
    {
        $item = static::getList([
            'select' => ['*', 'ELEMENT.*'],
            'filter' => [
                "=ELEMENT.".static::$field_xml_id => $xmlId
            ]
        ])->fetchObject();
        
        return $item;
    }
}
