<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Repositories\MutualSettlements;

use Sntinvest\Integration\Repositories\Repository;

use Sntinvest\Integration\Repositories\MutualSettlements\OrderRepository;
use Sntinvest\Integration\Orm\Product\ProductTable;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Sale\Fuser;
use Sntinvest\Integration\Exceptions\InvalidEntryException;
use Bitrix\Main\Config\Option;
/**
 * Description of ApplicationRepository
 *
 * @author dimay
 */
class GoodRepository extends Repository
{
    private $order;
    
    private static $entity = ProductTable::class;
    
    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }
        
    public function findOrCreated($params)
    { 
        return null;
    }
   
    public function set(&$entry, $data) 
    {
        $entry = $this->order->find($data['ORDER_XML_ID']);

        $basket = $entry->getBasket();
        
        $collection = $entry->getShipmentCollection();
        
        $product = self::$entity::find($data['XML_ID']);
        
        if (!$product)
        {
            $data['NAME'] = 'Пустой товар';
                    
            $element = new \CIBlockElement;
            
            $elementId = $element->add([
                'IBLOCK_ID' => intval(Option::get(SI_MODULE_NAME, 'product_iblock_id')),
                'XML_ID' => $data['XML_ID'],
                'NAME' => $data['NAME'],
            ]);
            
            $object = static::$entity::newObject();
            
            $object->setId($elementId);
            
            $result = $object->save();
            
            if ($result->isSuccess())
            {
                $product = self::$entity::find($data['XML_ID']);
            }
            else 
            {
                throw new InvalidEntryException('Entity not save: ' . implode(',', $result->getErrors()));
            }
        }
        
        if (is_null($product))
        {
            throw new InvalidEntryException('Entity not fount or not save');
        }
        
        foreach ($basket as $basketItem)
        {
            if (intval($product->getId()) === intval($basketItem->getProductId())
                                                            && intval($basketItem->getProductId()) > 0)
            {
                $item = $basketItem;
                break;
            }
        }
        
        if (!isset($item) || is_null($item))
        {
            $item = $basket->createItem('catalog', $product->getId());
            
            $item->setFields(array(
                'CURRENCY' =>  CurrencyManager::getBaseCurrency(),
                'LID' => "s1",
            ));
        }    
        
        if (isset($item) && !is_null($item))
        {
            $item->setFields([
                'QUANTITY' => $data['QUANTITY'],
                'PRICE' => $data['PRICE'],
                'NAME' => $product->getElement()->getName(),
            ]);
            
            foreach ($collection as $shipment)
            {
                if ($shipment->getField('XML_ID') === $data['SHIPMENT_XML_ID'])
                {
                    if (intval($data['QUANTITY']) > 0)
                    {
                        $shipmentItemCollection = $shipment->getShipmentItemCollection();
                        $shipmentItem = $shipmentItemCollection->createItem($item);
                        $shipmentItem->setQuantity($item->getQuantity());
                    }
                    else
                    {
                        $item->delete();
                    }
                }
            }
        }  
        
        if (intval($basket->getFUserId()) <= 0)
        {
            $basket->setFUserId(Fuser::getIdByUserId(SI_MODULE_AUTH_USER));
        }
    }
}
