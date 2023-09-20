<?php

/*
 * This file is part of bus-stage.sntinvest.ru project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Orm\Company;

use Bitrix\Crm\CompanyTable as BX_CompanyTable;

/**
 * Description of Company
 *
 * @author dimay
 */
class CompanyTable extends BX_CompanyTable
{
    private static $field_xml_id = 'ORIGIN_ID';
    
    /**
     * Override parent method to get object
     * @return string
     */
    public static function getObjectClass()
    {
        return EO_Company::class;
    }
    
    /**
     * Override parent method to get collection
     * @return string
     */
    public static function getCollectionClass(){
        return EO_Company_Collection::class;
    }
    
    /**
     * Override parent method to get map
     * @return array
     */
    public static function getMap()
    {
        $arMap = parent::getMap();
        
        return array_merge($arMap ?? [], [
            static::$field_xml_id => array(
                'data_type' => 'string'
            ),
        ]);
    }
    
    /**
     * Getting a new object
     * @return \Sntinvest\Integration\Orm\Company\class
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
            'filter' => [
                "=".static::$field_xml_id => $xmlId
            ]
        ])->fetchObject();
        
        return $item;
    }
}
