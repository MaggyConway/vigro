<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Repositories\Product;

use Sntinvest\Integration\Repositories\Repository;

use Sntinvest\Integration\Orm\Iblock\ElementTable;
use Sntinvest\Integration\Orm\Iblock\PropertyTable;
use Sntinvest\Integration\Orm\Iblock\PropertyEnumTable;
use Bitrix\Main\Config\Option;

/**
 * Description of CompanyRepository
 *
 * @author dimay
 */
class ProductRepository extends Repository
{
    private const CREATED_BY = SI_MODULE_AUTH_USER;
    private const MODIFIED_BY = SI_MODULE_AUTH_USER;

    private static $entity = ElementTable::class;
    private static $entityProperty = PropertyTable::class;
    private static $entityPropertyEnum = PropertyEnumTable::class;
    
    public function findOrCreated($params)
    {
        $item = static::$entity::findOrCreated([
            "IBLOCK_ID"     => intval(Option::get(SI_MODULE_NAME, 'product_iblock_id')),
            "XML_ID"        => $params['XML_ID'],
            "NAME"          => $params['NAME'],
        ]);
        
        return $item;
    }
    
    public function find($xmlId)
    {
        $item = static::$entity::find($xmlId);
        
        return $item;
    }
    
    public function set(&$entry, $data) 
    {
        $arFields = [
            "NAME"                  => $data['NAME'],
            "ACTIVE"                => $data['ACTIVE'],   
            "PREVIEW_TEXT"          => $data['PREVIEW_TEXT'],
            "PREVIEW_TEXT_TYPE"     => $data['PREVIEW_TEXT_TYPE'],
            "DETAIL_TEXT"           => $data['DETAIL_TEXT'],
            "DETAIL_TEXT_TYPE"      => $data['DETAIL_TEXT_TYPE'],
            "CREATED_BY"            => static::CREATED_BY,
            "MODIFIED_BY"           => static::MODIFIED_BY,
        ];
        
        foreach ($data['PROPERTY_VALUES'] as $prop)
        {
            $propEntry = static::$entityProperty::findOrCreated([
                "NAME"    => $prop["NAME"],
                "ACTIVE"  => $prop["ACTIVE"],
                "CODE"    => $prop["CODE"],
                "PROPERTY_TYPE" => $prop["PROPERTY_TYPE"],
                "IBLOCK_ID" => intval(Option::get(SI_MODULE_NAME, 'product_iblock_id')),//номер вашего инфоблока
                "LIST_TYPE" => $prop["LIST_TYPE"] ?? "L",
                "MULTIPLE" => $prop["MULTIPLE"] ?? "N",
            ]);
            
            if ($prop["PROPERTY_TYPE"] === 'E')
            {
                continue;
            }
            elseif ($prop["PROPERTY_TYPE"] === 'L')
            {
                if (is_string($prop['VALUE']['VALUE']) && strlen($prop['VALUE']['VALUE']) > 0
                        && is_string($prop['VALUE']['XML_ID']) && strlen($prop['VALUE']['XML_ID']) > 0)
                {
                    $propEntryEnum = static::$entityPropertyEnum::findOrCreated([
                        'PROPERTY_ID' => $propEntry->getId(),
                        'VALUE' => $prop['VALUE']['VALUE'],
                        'XML_ID' => $prop['VALUE']['XML_ID'],
                    ]);

                    $propValue = $propEntryEnum->getId();
                }
                else
                {
                    continue;
                }
            }
            else
            {
                if (!is_null($prop['VALUE']))
                {
                    $propValue = $prop['VALUE'];
                }
                else
                {
                    continue;
                }
            }
            
            $arFields['PROPERTY_VALUES'][$propEntry->getId()] = $propValue;
        }
        
        $entry->setData($arFields);
    }
}
