<?php

/*
 * This file is part of maxonor project
 * Copyright 2022 dimay.
 */

namespace Silab\SiteCore\Repositories\Market;

use Sntinvest\Market\Orm\OzonProductsTable;

/**
 * Description of OzonProductsRepository
 *
 * @author dimay
 */
class OzonProductsRepository 
{
    public function getByUfOfferId($offetId)
    {
        if (
                \Bitrix\Main\Loader::includeModule('sntinvest.market')
                && intval($offetId) > 0
            )
        {
            return OzonProductsTable::getList([
                'filter' => [
                    'UF_OFFER_ID' => $offetId
                ]
            ])->fetch();
        }
        
        return null;
    }
}
