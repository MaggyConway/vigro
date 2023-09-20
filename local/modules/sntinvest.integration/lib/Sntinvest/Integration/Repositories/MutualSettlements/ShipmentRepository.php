<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Repositories\MutualSettlements;

use Sntinvest\Integration\Repositories\Repository;

use Sntinvest\Integration\Repositories\MutualSettlements\OrderRepository;
use Sntinvest\Integration\Orm\Order\Payment\PaymentTable;
use Bitrix\Main\Type\Date;
use Bitrix\Sale\Delivery\Services\Manager;
use Bitrix\Sale\Delivery\Services\EmptyDeliveryService;

/**
 * Description of ApplicationRepository
 *
 * @author dimay
 */
class ShipmentRepository extends Repository
{
    private $order;
    
    private static $entity = PaymentTable::class;

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
        /**
         * TODO: Объеденить отгрузки с товарами
         */
        
        $entry = $this->order->findOrCreateDefault($data['ORDER_XML_ID']);
        
        $collection = $entry->getShipmentCollection();
        
        $service = Manager::getById(EmptyDeliveryService::getEmptyDeliveryServiceId());

        foreach ($collection as $ship)
        {
            if ($ship->getField('XML_ID') === $data['XML_ID'])
            {
                $shipment = $ship;
                break;
            }
        }
        
        if (!isset($shipment) || is_null($shipment))
        {
            $shipment = $collection->createItem();
            
            $shipment->setFields([
                'XML_ID' => $data['XML_ID'],
                'DELIVERY_ID' => $service['ID'],
                'DELIVERY_NAME' => $service['NAME'],
            ]);
        }    
        
        if (isset($shipment) && !is_null($shipment))
        {
//            $shipment->setFields([
//            ]);
        }  
    }
}
