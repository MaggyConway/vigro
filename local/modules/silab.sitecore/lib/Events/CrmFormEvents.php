<?php

namespace Silab\SiteCore\Events;

class CrmFormEvents
{
    public static function OnAfterIBlockElementAdd (&$arFields)
    {
        $iblockIds = explode(',', $_ENV['CRM_FORM_CALLBACK_IBLOCK_ID'] ?? []);
        
        if (in_array($arFields['IBLOCK_ID'], $iblockIds))
        {
            if (isset($_ENV['CRM_FORM_CALLBACK_RESPONSIBLE_ID'])
                && intval($_ENV['CRM_FORM_CALLBACK_RESPONSIBLE_ID']) > 0
            )
            {
                $res = \CIBlock::GetByID($arFields['IBLOCK_ID']);
                
                if($arIblock = $res->GetNext())
                {
                    $title = $arIblock['NAME'];
                }
                else
                {
                    $title = "Заявка с сайта максонор";
                }
                
                $descipteion = "NAME: " . $arFields['NAME'];
                
                foreach ($arFields['PROPERTY_VALUES'] as $key=>$val)
                {
                    $descipteion .= "<br>$key: " . $val;
                }
                
                $arData = array(
                    "fields" => array(
                        "TITLE" => $title,
                        "RESPONSIBLE_ID" => $_ENV['CRM_FORM_CALLBACK_RESPONSIBLE_ID'],
                        'DESCRIPTION' => $descipteion,
                        'GROUP_ID' => $_ENV['CRM_FORM_CALLBACK_GROUP_ID'] ?? 0,
                        'TAGS' =>  ['ЗаявкаMaxonor', 'Maxonor'],
                    )
                );
                
                static::sendData('tasks.task.add', $arData);
            }
        }
        
        
    }
    
    protected static function sendData($methods = false, $arParams = array())
    {
        try 
        {
            if (!is_string($methods) || strlen($methods) <= 0)
                throw new \Exception ('not methods');
         
            if ( !is_string($_ENV['BITRIX_24_REST']) || strlen($_ENV['BITRIX_24_REST']) <= 0)
                throw new \Exception ('not WEBHOOK');
                          
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HEADER, 0);
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            curl_setopt($ch, CURLOPT_URL, $_ENV['BITRIX_24_REST'] . $methods);
            
            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arParams));

            $data = curl_exec($ch);
            
            $res = json_decode($data, true);
            
            curl_close($ch);
            
            return $res;
        }
        catch (Exception $ex) 
        {
            return false;
        }
    }
}