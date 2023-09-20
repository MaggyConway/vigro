<?php

/*
 * This file is part of maxonor project
 * Copyright 2022 dimay.
 */

namespace Silab\SiteCore\Services;

use Silab\SiteCore\Repositories\ProductRepository;
use Silab\SiteCore\Repositories\Market\{
    OzonProductsRepository,
    YandexProductsRepository,
};

/**
 * Description of MarketService
 *
 * @author dimay
 */
class MarketService
{
    protected $ozonProductRepository;
    
    public function __construct() 
    {
        $this->ozonProductRepository = new OzonProductsRepository();
        $this->yandexProductRepository = new YandexProductsRepository();
    }
    
    public function getLinkOzon($offerID) : string
    {
        $result = $this->ozonProductRepository->getByUfOfferId($offerID);
        
        if (isset($result['UF_SKU']) && !empty($result['UF_SKU']))
        {
            return sprintf(
                'https://ozon.ru/context/detail/id/%s/', 
                $result['UF_SKU']
            );
        }
        
        return '';
    }
    
    public function getLinkYandex($offerID) : string
    {
        $result = $this->yandexProductRepository->getByUfOfferId($offerID);
        
        if (
            isset($result['UF_MARKET_SKU']) && !empty($result['UF_MARKET_SKU'])
            && isset($result['UF_MODEL_ID']) && !empty($result['UF_MODEL_ID'])
        )
        {
            return sprintf(
                'https://market.yandex.ru/product/%s?sku=%s', 
                $result['UF_MODEL_ID'],
                $result['UF_MARKET_SKU'],
            );
        }
        
        return '';
    }
}
