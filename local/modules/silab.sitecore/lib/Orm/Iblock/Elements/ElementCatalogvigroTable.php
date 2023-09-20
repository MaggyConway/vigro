<?php

/*
 * This file is part of maxonor project
 * Copyright 2022 dimay.
 */

namespace Silab\SiteCore\Orm\Iblock\Elements;

use Bitrix\Iblock\Elements\ElementCatalogvigroTable as BX_ElementCatalogvigroTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Iblock\SectionElementTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Query\Join;

/**
 * Description of ElementCatalogTable
 *
 * @author dimay
 */
class ElementCatalogvigroTable extends BX_ElementCatalogvigroTable
{
    
    /**
     * Override parent method to get object
     * @return string
     */
    public static function getObjectClass()
    {
        return EO_ElementCatalogvigro::class;
    }
    
    /**
     * Override parent method to get collection
     * @return string
     */
    public static function getCollectionClass(){
        return EO_ElementCatalogvigro_Collection::class;
    }
    
    /**
     * Override parent method to get map
     * @return array
     */
    public static function getMap()
    {
        $arMap = parent::getMap();
        
        return array_merge($arMap ?? [], [
            
            'IBLOCK' => (new Reference(
                    'IBLOCK',
                    IblockTable::class,
                    Join::on('this.IBLOCK_ID', 'ref.ID')
                ))
                ->configureJoinType('inner'),
                
            'IBLOCK_SECTION' => (new ManyToMany('SECTION', SectionTable::class))
                ->configureTableName(SectionElementTable::getTableName())
                ->configureLocalPrimary('ID', 'IBLOCK_SECTION_ID')
                ->configureLocalReference('IBLOCK_SECTION')
                ->configureRemotePrimary('ID', 'IBLOCK_ELEMENT_ID')
                ->configureRemoteReference('IBLOCK_ELEMENT')
        ]);
    }
        
}
