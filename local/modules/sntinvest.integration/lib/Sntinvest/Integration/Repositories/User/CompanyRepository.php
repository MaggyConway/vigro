<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Repositories\User;

use Sntinvest\Integration\Interfaces\UserRepositoryInterface;
use Sntinvest\Integration\Repositories\Repository;

use Sntinvest\Integration\Orm\Company\CompanyTable;
use Bitrix\Main\Type\DateTime;

/**
 * Description of CompanyRepository
 *
 * @author dimay
 */
class CompanyRepository extends Repository
                            implements UserRepositoryInterface
{
    private static $entity = CompanyTable::class;
    
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
        
        $entry->setTitle($data['NAME']);
        $entry->setDateModify(new DateTime());
        $entry->setModifyById(SI_MODULE_AUTH_USER);

        $entry->setSearchContent(implode(' ', array_merge([$entry->getId() ?? ''], $data)));        
    }
    
    public function findOrCreateDefault($xmlId) 
    {
        $entry = $this->findOrCreated($xmlId);
        
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
