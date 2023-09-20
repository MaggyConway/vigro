<?php

/*
 * This file is part of maxonor project
 * Copyright 2022 dimay.
 */

namespace Silab\SiteCore\Repositories\Market;

use Sntinvest\Market\Orm\YandexProductsTable;

/**
 * Description of OzonProductsRepository
 *
 * @author dimay
 */
class YandexProductsRepository 
{
    public function getByUfOfferId($offetId)
    {
        if (
                \Bitrix\Main\Loader::includeModule('sntinvest.market')
                && intval($offetId) > 0
            )
        {
            return YandexProductsTable::getList([
                'filter' => [
                    'UF_SHOP_SKU' => $offetId
                ]
            ])->fetch();
        }
        
        return null;
    }
}
