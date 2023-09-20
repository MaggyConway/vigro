<?php

/*
 * This file is part of bus-stage.sntinvest.ru project
 * Copyright 2022 dimay.
 */
 
namespace Sntinvest\Integration\Orm\Order;

use Bitrix\Crm\Binding\OrderContactCompanyTable as BX_OrderContactCompanyTable;

/**
 * Description of Company
 *
 * @author dimay
 */
class OrderContactCompanyTable extends BX_OrderContactCompanyTable
{
    public static function get($entytyId, $orderId)
    {        
        return static::getList([
            'filter' => [
                '=ENTITY_ID' => $entytyId,
                '=ORDER_ID' => $orderId
            ]
        ])->fetchObject();
    }
    
    public static function getByOrderId($orderId)
    {        
        return static::getList([
            'filter' => [
                '=ORDER_ID' => $orderId
            ]
        ])->fetchCollection();
    }
    
    public static function set($entytyId, $orderId, $type = 4) 
    {
        return static::add([
            'ENTITY_TYPE_ID' => $type,
            'ENTITY_ID' => $entytyId,
            'ORDER_ID' => $orderId,
            'IS_PRIMARY' => 'Y',
        ]);
    }
}
