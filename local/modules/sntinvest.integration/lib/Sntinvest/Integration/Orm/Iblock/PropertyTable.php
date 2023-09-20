<?php

/*
 * This file is part of bus-stage.sntinvest.ru project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Orm\Iblock;

use Bitrix\Iblock\PropertyTable as BX_PropertyTable;
use Sntinvest\Integration\Exceptions\InvalidEntryException;

/**
 * Description of Company
 *
 * @author dimay
 */
class PropertyTable extends BX_PropertyTable
{
    private static $field_xml_id = 'CODE';
    
    /**
     * Override parent method to get object
     * @return string
     */
    public static function getObjectClass()
    {
        return EO_Property::class;
    }
    
    /**
     * Override parent method to get collection
     * @return string
     */
    public static function getCollectionClass(){
        return EO_Property_Collection::class;
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
        $ibp = new \CIBlockProperty;
        
        $id = $ibp->Add($data);
        
        if (intval($id) > 0)
        {
            return static::find($data);
        }
        
        throw new InvalidEntryException('No create property table');
    }
    
    /**
     * 
     * @param type $data
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
     * @param type $data
     */
    public static function find($data)
    {
        $item = static::getList([
            'filter' => [
                "=".static::$field_xml_id => $data[static::$field_xml_id],
                "=IBLOCK_ID" => $data["IBLOCK_ID"],
            ],
        ])->fetchObject();
        
        return $item;
    }
}
