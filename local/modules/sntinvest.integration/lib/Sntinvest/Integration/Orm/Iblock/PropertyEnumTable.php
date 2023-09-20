<?php

/*
 * This file is part of bus-stage.sntinvest.ru project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Orm\Iblock;

use Bitrix\Iblock\PropertyEnumerationTable as BX_PropertyEnumTable;

use Sntinvest\Integration\Exceptions\InvalidEntryException;

/**
 * Description of Company
 *
 * @author dimay
 */
class PropertyEnumTable extends BX_PropertyEnumTable
{
    private static $field_xml_id = 'XML_ID';
    
    /**
     * Override parent method to get object
     * @return string
     */
    public static function getObjectClass()
    {
        return EO_PropertyEnum::class;
    }
    
    /**
     * Override parent method to get collection
     * @return string
     */
    public static function getCollectionClass(){
        return EO_PropertyEnum_Collection::class;
    }
    
    /**
     * Override parent method to get map
     * @return array
     */
    public static function getMap()
    {
        $arMap = parent::getMap();
        
        return array_merge($arMap ?? [], []);
    }
    
    /**
     * Getting a new object
     * @return \Sntinvest\Integration\Orm\Company\Company
     */
    public static function newObject($data)
    {
        $ibp = new \CIBlockPropertyEnum;
        
        $id = $ibp->Add($data);
        
        if (intval($id) > 0)
        {
            return static::find($data);
        }
        
        throw new InvalidEntryException('No create property enum table');
    }
    
    /**
     * 
     * @param type $xmlId
     */
    public static function findOrCreated($data)
    {
        $item = static::find($data);

        if (is_null($item))
        {
            $item = static::newObject($data);
        }
        
        return $item;
    }
    
    /**
     * 
     * @param type $xmlId
     */
    public static function find($data)
    {
        $item = static::getList([
            'filter' => [
                "=".static::$field_xml_id => $data[static::$field_xml_id],
                "=PROPERTY_ID" => $data["PROPERTY_ID"],
            ],
        ])->fetchObject();
        
        return $item;
    }
}
