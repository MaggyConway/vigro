<?php

/*
 * This file is part of bus-stage.sntinvest.ru project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Orm\Iblock;

use Bitrix\Iblock\EO_Element as BX_EO_Element;

/**
 * Description of Company
 *
 * @author dimay
 */
class EO_Element extends BX_EO_Element
{
    protected $arData = [];
    
    public function setPropertyByCode(string $code, $value)
    {
        if (!is_array($this->arData['PROPERTY_VALUES']))
            $this->arData['PROPERTY_VALUES'] = [];
        
        $this->arData['PROPERTY_VALUES'][$code] = $value;
    }
    
    public function setData(array $data)
    {
        $this->arData = $data;
    }

    public function saveByData() 
    {
        $ibe = new \CIBlockElement;
        
        $result = $ibe->Update($this->getId(), $this->arData);
        
        if (!$result)
        {
            dd($ibe->LAST_ERROR);
        }

        return $result;
    }
}
