<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Repositories\MutualSettlements;

use Sntinvest\Integration\Repositories\Repository;

use Sntinvest\Integration\Orm\Order\OrderTable;
use Sntinvest\Integration\Repositories\Product\ProductRepository;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Type\DateTime;
use Bitrix\Sale\Delivery\Services\Manager;
use Bitrix\Sale\Delivery\Services\EmptyDeliveryService;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Sale\Fuser;
use Bitrix\Sale\Basket;
use Bitrix\Main\Context;
use Bitrix\Sale\PaySystem\Manager as PayManager;

/**
 * Description of ApplicationRepository
 *
 * @author dimay
 */
class OrderRepository extends Repository
{
    private static $entity = OrderTable::class;
    
    private $productRepository;

    public const ORDER_PROPS_OLD_DEAL = SI_MODULE_ORDER_PROPS_OLD_DEAL;
    public const ORDER_PROPS_CACHBACK = SI_MODULE_ORDER_PROPS_CACHBACK;
    public const USER_ID = SI_MODULE_AUTH_USER;
    public const DEFAULT_PERSON_TYPE = 3;
    
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
        
    public function find($xml)
    {
        $item = static::$entity::find($xml);
        
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
            $entry->setField('XML_ID', $data['XML_ID']);
        }
        
        $date = DateTime::createFromPhp(new \DateTime($data['DATE_CREATE'])); // преобразуем дату 
        $entry->setField('DATE_INSERT',$date);
        $entry->setPersonTypeId(static::DEFAULT_PERSON_TYPE);
        $entry->setField('ORDER_TOPIC', $data['NUMBER']);
        $entry->setField('STATUS_ID', $data['STATUS']);
         
        if (isset($data['USER_ID']))
        {
            $entry->setFieldNoDemand('USER_ID', $data['USER_ID']);
            $entry->setField('RESPONSIBLE_ID', $data['USER_ID']);
        }
        
        $this->setPropertyCollection($entry, $data);
        
        $arShipment = [];
        $arPayments = [];
        $arProducts = [];
        
        foreach ($data["SHIPMENTS"] as $shipment)
        {
            $arShipment[$shipment['XML_ID']] = $shipment;
            
            $arGoods = [];
            
            foreach ($shipment["GOODS"] as $good)
            {
                $arGoods[$good['XML_ID']] = $good;
            }
            
            $arProducts = array_merge($arProducts, $arGoods);
            
            $arShipment[$shipment['XML_ID']]['GOODS'] = $arGoods;
        }
        
        foreach ($data["PAYNEMTS"] as $payment)
        {
            $arPayments[$payment['XML_ID']] = $payment;
        }
        
        $this->setBasket($entry, $arProducts);
        
        $this->setShipmentCollection($entry, $arShipment);
        
        $this->setPaymentCollection($entry, $arPayments);
        
        $this->setPropertyCollection($entry, $data);
        
        $entry->save();      
    }
    
    private function setPropertyCollection(&$entry, $data) 
    {
        $propertyCollection = $entry->getPropertyCollection();
        
        foreach ($propertyCollection as $prop)
        {
            if($prop->getField('ORDER_PROPS_ID') == static::ORDER_PROPS_CACHBACK) 
            {
                $prop->setValue($data['CACHBACK']);
                
                return true;
            }
        }
    }
    
    private function setPaymentCollection(&$entry, $arPayments) 
    {
        $paymentCollection = $entry->getPaymentCollection();
        
        $paySystemService = PayManager::getObjectById(1);
        
        foreach ($paymentCollection as $payment)
        {
            $xmlId = $payment->getField('XML_ID');
            
            if (isset($arPayments[$xmlId]))
            {
                $item = $arPayments[$xmlId];
                
                //update
                $payment->setFields([
                    'SUM' => $item['SUM'],
                    'PAID' => $item['STATUS'],
                    'DATE_PAID' => DateTime::createFromPhp(new \DateTime($item['DATE_PAY'])),
                ]);
                
                unset($arPayments[$xmlId]);
            }
            else
            {
                //delete
                $payment->delete();
            }
        }
        
        //add
        if (is_array($arPayments) && count($arPayments) > 0)
        {
            foreach ($arPayments as $item)
            {
                $payment = $paymentCollection->createItem();
                
                //Из за сточки кода в этом методе: https://bxapi.ru/src/?module_id=sale&name=Payment::onFieldModify 
                //чтобы поле DATE_PAID формировалось правильно при создании
                
                //Пишем сумму и статус 
                $payment->setField('SUM', $item['SUM']);
                $payment->setField('PAID', $item['STATUS']);
                
                //Удаляем лог изменения по полям
                $payment->clearChanged();
                
                //пишем все остальные поля 
                $payment->setFields(array(
                    //static
                    'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
                    'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
                    'XML_ID' => $item['XML_ID'],
                    'ACCOUNT_NUMBER' => $item['NUMBER'],
                    'DATE_BILL' => Date::createFromPhp(new \DateTime($item['DATE_CREATE'])),
                    'DATE_PAY_BEFORE' => Date::createFromPhp(new \DateTime($item['DATE_PAY_BEFORE'])),
                    //dinamic
                    'DATE_PAID' => DateTime::createFromPhp(new \DateTime($item['DATE_PAY'])),
                ));
            }
        }
    }
    
    private function setShipmentCollection(&$entry, $arShipment) 
    {
        $basket = $entry->getBasket();
        
        $service = Manager::getById(EmptyDeliveryService::getEmptyDeliveryServiceId());
        
        $shipmentCollection = $entry->getShipmentCollection();
        
        foreach ($shipmentCollection as $ship)
        {
            $xmlId = $ship->getField('XML_ID');
            
            if (isset($arShipment[$xmlId]))
            {
                //update
                $item = $arShipment[$xmlId];
                
                $this->setGoogsShipment($basket, $ship, $item['GOODS']);
                
                $ship->setFields([
                    'STATUS_ID' => $item['STATUS'],
                    'DEDUCTED' => intval($item['DELEVERY'])> 0 ? 'Y' : 'N',
                    'ALLOW_DELIVERY' => intval($item['DELEVERY'])> 0 ? 'Y' : 'N',
                ]);
                
                unset($arShipment[$xmlId]);
            }
            else
            {
                //delete
//                $ship->delete();
            }
        }
        
        //add
        if (count($arShipment) > 0)
        {
            foreach ($arShipment as $item)
            {
                $shipment = $shipmentCollection->createItem();
                
                $this->setGoogsShipment($basket, $shipment, $item['GOODS']);
                
                $shipment->setFields([
                    //static
                    'XML_ID' => $item['XML_ID'],
                    'DELIVERY_ID' => $service['ID'],
                    'DELIVERY_NAME' => $service['NAME'],
                    'DELIVERY_DOC_DATE' => Date::createFromPhp(new \DateTime($item['DATE_CREATE'])),
                    'DELIVERY_DOC_NUM' => $item['NUMBER'],
                    'ACCOUNT_NUMBER' => $item['NUMBER'],
                    //dinamic
                    'STATUS_ID' => $item['STATUS'],
                    'DEDUCTED' => intval($item['DELEVERY'])> 0 ? 'Y' : 'N',
                    'ALLOW_DELIVERY' => intval($item['DELEVERY'])> 0 ? 'Y' : 'N',
                ]);
                
                $shipment->setFieldNoDemand('DATE_INSERT', DateTime::createFromPhp(new \DateTime($item['DATE_CREATE'])));
                
            }
            
        }
    }
    
    private function setBasket(&$entry, $arProducts) 
    {
        $basket = $entry->getBasket();
        
        $siteId = Context::getCurrent()->getSite();
                
        if (is_null($basket))
        {
            $basket = Basket::create($siteId);
            $entry->setBasket($basket);
        }
        
        if (intval($basket->getFUserId()) <= 0)
        {
            $basket->setFUserId(Fuser::getIdByUserId(SI_MODULE_AUTH_USER));
        }
        
        foreach ($basket as $basketItem)
        {
            $xmlId = $basketItem->getField('XML_ID');
            
            if (isset($arProducts[$xmlId]))
            {
                //update
                $item = $arProducts[$xmlId];
                
                $basketItem->setFields([
                    'QUANTITY' => $item['QUANTITY'],
                    'PRICE' => $item['PRICE'],
                ]);
                
                unset($arProducts[$xmlId]);
            }
            else
            {
                //delete
                $basketItem->delete();
            }
        }
        
        //add
        if (is_array($arProducts) && count($arProducts) > 0)
        {
            $db = $this->productRepository->getList([], [
                '=XML_ID' => array_keys($arProducts),
            ], false, false, ['ID', 'XML_ID', 'NAME']);

            while ($row = $db->Fetch())
            {
                $arProducts[$row['XML_ID']]['ID'] = $row['ID'];
                $arProducts[$row['XML_ID']]['NAME'] = $row['NAME'];
            }

            foreach ($arProducts as $item)
            {
                $basketItem = $basket->createItem('catalog', $item['ID']);

                $basketItem->markFieldCustom('PRICE');
                
                $basketItem->setFields(array(
                    //static
                    'XML_ID' => $item['XML_ID'],
                    'CURRENCY' =>  CurrencyManager::getBaseCurrency(),
                    'LID' => $siteId,
                    'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
                    'NAME' => $item['NAME'],
                    //dinamic
                    'QUANTITY' => $item['QUANTITY'],
                    'PRICE' => $item['PRICE'],
                ));
                
            }
        }
    }

    private function setGoogsShipment($basket, &$shipment, $arGoods)
    {
        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        
        $arProducts = [];
        
        foreach ($basket as $basketItem)
        {
            $xmlId = $basketItem->getField('XML_ID');
            
            if (isset($arGoods[$xmlId]))
            {
                $arProducts[$xmlId] = $basketItem;
            }
        }
        
        foreach ($shipmentItemCollection as $shipmentItem)
        {
           $xmlId = $shipmentItem->getField('XML_ID');
            
            if (isset($arProducts[$xmlId]))
            {
                $item = $arProducts[$xmlId];
                
                $shipmentItem->setFields([
                    'QUANTITY' => $item->getQuantity(),
                ]);
                
                unset($arProducts[$xmlId]);
            }
            else
            {
                //delete
                $shipmentItem->delete();
            }
        }
        
        //add
        if (is_array($arProducts) && count($arProducts) > 0)
        {
            foreach ($arProducts as $item)
            {
                $shipmentItem = $shipmentItemCollection->createItem($item);
                
                $shipmentItem->setFields([
                    'QUANTITY' => $item->getQuantity(),
                    'XML_ID' => $item->getField('XML_ID'),
                ]);
            }
        }
    }

    public function findOrCreateDefault($xmlId) 
    {
        $entry = $this->findOrCreated($xmlId);
        
        if (intval($entry->getId()) <= 0)
        {
            $entry->setField('XML_ID', $xmlId);
            
            $entry->save();
        }
        
        return $entry;
    }
}
