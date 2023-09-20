<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Repositories\MutualSettlements;

use Sntinvest\Integration\Repositories\Repository;

use Sntinvest\Integration\Orm\Deal\DealTable;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Type\Date;

/**
 * Description of ApplicationRepository
 *
 * @author dimay
 */
class ApplicationRepository extends Repository
{
    private static $entity = DealTable::class;
        
    public function find($xmlId)
    {
        $item = static::$entity::find($xmlId);
        
        return $item;
    }
        
    public function findOrCreated($params)
    {
        $item = static::$entity::findOrCreated($params);
        
        return $item;
    }
    
    public function set(&$entry, $data) 
    {
        //create if new 
        if (intval($entry->getId()) <= 0)
        {
            $entry->setOriginId($data['XML_ID']);
            $entry->setDateCreate(new DateTime());
            $entry->setCreatedById(SI_MODULE_AUTH_USER);
            $entry->save();
        }
        
        $entry->setTitle('Заказ №' . $data['NUMBER']);
        
        $entry->setDateModify(new DateTime());
        
        $entry->setModifyById(SI_MODULE_AUTH_USER);
        
        $entry->setAssignedById($data['ASSIGNED_BY_ID'] ?? SI_MODULE_AUTH_USER);
        
        $entry->setStageId($data['STATUS']);
        
        $entry->setBegindate(Date::createFromPhp(new \DateTime($data['DATE_CREATE'])));
        
        $entry->setCompany($data['COMPANY']);
        
        $entry->setSourceId($data['SOURCE']);

        $entry->setSearchContent(implode(' ', array_merge([$entry->getId() ?? ''], $data)));        
    }
    
    public function findOrCreateDefault($xmlId) 
    {
        $entry = $this->findOrCreated($xmlId);
        
        //create if new 
        if (intval($entry->getId()) <= 0)
        {
            $entry->setOriginId($xmlId);
            $entry->setDateCreate(new DateTime());
            $entry->setCreatedById(SI_MODULE_AUTH_USER);
            $entry->save();
        }       
        
        return $entry;
    }
}
