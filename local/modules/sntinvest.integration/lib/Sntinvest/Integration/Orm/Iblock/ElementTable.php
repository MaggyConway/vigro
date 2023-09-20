<?php

/*
 * This file is part of bus-stage.sntinvest.ru project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Orm\Iblock;

use Bitrix\Iblock\ElementTable as BX_ElementTable;
use Sntinvest\Integration\Exceptions\InvalidEntryException;
/**
 * Description of Company
 *
 * @author dimay
 */
class ElementTable extends BX_ElementTable
{
    private static $field_xml_id = 'XML_ID';
    
    /**
     * Override parent method to get object
     * @return string
     */
    public static function getObjectClass()
    {
        return EO_Element::class;
    }
    
    /**
     * Override parent method to get collection
     * @return string
     */
    public static function getCollectionClass(){
        return EO_Element_Collection::class;
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
        $ibp = new \CIBlockElement;
        
        $id = $ibp->Add($data);

        if (intval($id) > 0)
        {
            return static::find($data);
        }
        
        throw new InvalidEntryException('No create element table: '. $ibp->LAST_ERROR);
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
        $filter = [
                "=".static::$field_xml_id => $data[static::$field_xml_id],
            ];
        
        if (!is_null($data['IBLOCK_ID']))
        {
            $filter['=IBLOCK_ID'] = $data['IBLOCK_ID'];
        }
        
        $item = static::getList([
            'filter' => $filter,
        ])->fetchObject();
        
        return $item;
    }
}
