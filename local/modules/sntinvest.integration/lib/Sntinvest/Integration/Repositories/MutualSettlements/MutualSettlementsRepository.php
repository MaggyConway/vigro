<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Repositories\MutualSettlements;

use Sntinvest\Integration\Repositories\Repository;
use Sntinvest\Integration\Container;
use Sntinvest\Integration\Orm\Deal\DealTable;
use Sntinvest\Integration\Orm\Order\OrderDealTable;
use Sntinvest\Integration\Orm\Order\OrderContactCompanyTable;
use Sntinvest\Integration\Interfaces\UserRepositoryInterface;
use Sntinvest\Integration\Repositories\Product\ProductRepository;

/**
 * Description of ApplicationRepository
 *
 * @author dimay
 */
class MutualSettlementsRepository extends Repository
{
    private static $entityApplication = DealTable::class;
        
    public function find($xmlId)
    {
        $item = static::$entityApplication::find($xmlId);
        
        return $item;
    }
        
    public function findOrCreated($params)
    {
        $item = static::$entityApplication::findOrCreated($params);
        
        return $item;
    }
    
    private function repositoryApplication() 
    {
        return Container::getInstance()->get(ApplicationRepository::class);
    }
    
    private function repositoryOrder() 
    {
        return Container::getInstance()->get(OrderRepository::class);
    }
    
    private function repositoryCompany() 
    {
        return Container::getInstance()->get(UserRepositoryInterface::class);
    }
    
    private function repositoryProduct() 
    {
        return Container::getInstance()->get(ProductRepository::class);
    }

    public function set(&$entry, $data) 
    {
        $repositoryApplication = $this->repositoryApplication();
        $repositoryOrder = $this->repositoryOrder();
        $repositoryCompany = $this->repositoryCompany();
        
        $company = $repositoryCompany->findOrCreateDefault($data['COMPANY']);
         
        //to update deal 
        $repositoryApplication->set($entry, $data);
        
        $arProducts = [];
        
        //to update orders
        foreach ($data['ORDERS'] as $orderData)
        {
            if (isset($orderData['XML_ID'])
                && !empty($orderData['XML_ID']))
            {
                $entryOrder = $repositoryOrder->findOrCreated($orderData['XML_ID']);
                
                $orderData['USER_ID'] = $orderData['USER_ID'] ?? $data['ASSIGNED_BY_ID'];
                
                $repositoryOrder->set($entryOrder, $orderData);
                
                foreach ($entryOrder->getBasket() as $basketItem)
                {
                    $arProducts[$basketItem->getField('XML_ID')] = [
                        "QUANTITY" => $basketItem->getField('QUANTITY'),
                        "PRICE" => $basketItem->getField('PRICE'),
                    ];
                }
                
                $entryOrder->save();
                
                $this->setOrderDeal($entry->getId(), $entryOrder->getId());
                $this->setOrderContactCompany($company->getId(), $entryOrder->getId());
            }
        }
        
        $entry->setOpportunity($this->setDealBasket($entry, $arProducts));
    }
    
    private function setOrderContactCompany($contactOrCompanyId, $orderId)
    {
        $isSeet = OrderContactCompanyTable::get($contactOrCompanyId, $orderId);
        
        if (is_null($isSeet))
        {
            $items = OrderContactCompanyTable::getByOrderId($orderId);
            
            foreach ($items as $item)
            {
                $item->delete();
            }
            
            OrderContactCompanyTable::set($contactOrCompanyId, $orderId);
        }
    }
    
    private function setOrderDeal($dealId, $orderId)
    {
        $isSeet = OrderDealTable::get($dealId, $orderId);
        
        if (is_null($isSeet))
        {
            OrderDealTable::set($dealId, $orderId);
        }
    }
    
    private function setDealBasket($entry, $arProducts)
    {
        $totalSumm = 0;
        
        foreach ($arProducts as $index=>$product)
        {
            $totalSumm += $product["PRICE"] * $product["QUANTITY"];
            $arProducts[$index]['PRODUCT_NAME'] = 'Товары не найден';
        }
        
        $db = $this->repositoryProduct()->getList([], [
            '=XML_ID' => array_keys($arProducts),
        ], false, false, ['ID', 'XML_ID']);
            
        while ($row = $db->Fetch())
        {
            $arProducts[$row['XML_ID']]['PRODUCT_ID'] = $row['ID'];
            unset($arProducts[$row['XML_ID']]['PRODUCT_NAME']);
        }
        
        \CCrmDeal::SaveProductRows($entry->getId(), array_values($arProducts));
        
        return $totalSumm;
    }
}
