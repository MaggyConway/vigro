<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Events;

use Sntinvest\Integration\Interfaces\{
    EventInterface
};

use Sntinvest\Integration\Services\SectionService;
use Sntinvest\Integration\Container;

use Bitrix\Main\Config\Option;

/**
 * Description of OnUserAdd
 *
 * @author dimay
 */
class OnSectionEvent implements EventInterface
{
    private $service;
    
    private static $select = [
        "ID", 
        "IBLOCK_ID", 
        "XML_ID", 
        "NAME", 
        "ACTIVE", 
        "PREVIEW_TEXT", 
        "PREVIEW_TEXT_TYPE", 
        "DETAIL_TEXT", 
        "DETAIL_TEXT_TYPE",
    ];
    
    public function __construct(SectionService $service) 
    {
        $this->service = $service;
    }
    
    public function handler($param)
    {
        if (!isset($this))
        {
            //new object and call seld method
            return Container::callMethod(
                Container::getClassData(
                    __NAMESPACE__,
                    __METHOD__,
                    $param,
                )
            );
        }
        
        if (intval($param['IBLOCK_ID']) === intval(Option::get(SI_MODULE_NAME, 'product_iblock_id'))
                && intval($param['IBLOCK_ID']) > 0
                && intval($param['ID']) > 0
                && $param['RESULT'])
        {
            $method = static::$serviceMethod ?? 'from';

            $this->service->$method([$param]);
        }
    }
    
    
    public function getFields($arFields) 
    {
        $arList = [];
                
        foreach ($arFields as $key=>$value)
        {
            if (in_array($key, static::$select)
                    && count(static::$select) > 0
                    && strripos($key, '~') === FALSE)
            {
                $arList[$key] = $value;
            }
        }
        
        return $arList;
    }
    
    public function GetProperties($arProperties) 
    {
        $arList = [];
                
        foreach ($arProperties as $key=>$prop)
        {
            $arList[$key] = [
                "NAME"    => $prop["NAME"],
                "ACTIVE"  => $prop["ACTIVE"],
                "CODE"    => $prop["CODE"],
                "PROPERTY_TYPE" => $prop["PROPERTY_TYPE"],
                "LIST_TYPE" => $prop["LIST_TYPE"] ?? "L",
                "MULTIPLE" => $prop["MULTIPLE"] ?? "N",
                "IS_REQUIRED" => $prop["IS_REQUIRED"] ?? "N",
                'VALUE_XML_ID' => $prop["VALUE_XML_ID"],
                'VALUE' => $prop["VALUE"],
            ];
            
            if ($prop["PROPERTY_TYPE"] === 'E')
            {
                continue;
            }
            elseif ($prop["PROPERTY_TYPE"] === 'L')
            {
                $arList[$key]['VALUE'] = [
                    'XML_ID' => $prop["VALUE_XML_ID"],
                    'VALUE' => $prop["VALUE"],
                ];
            }
            else
            {
                $arList[$key]['VALUE'] = $prop['VALUE'];
            }
        }
        
        return $arList;
    }
}
