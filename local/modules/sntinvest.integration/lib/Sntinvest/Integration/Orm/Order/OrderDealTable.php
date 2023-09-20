<?php

/*
 * This file is part of bus-stage.sntinvest.ru project
 * Copyright 2022 dimay.
 */
 
namespace Sntinvest\Integration\Orm\Order;

use Bitrix\Crm\Binding\OrderDealTable as BX_OrderDealTable;

/**
 * Description of Company
 *
 * @author dimay
 */
class OrderDealTable extends BX_OrderDealTable
{
    public static function get($dealId, $orderId)
    {
        return static::getList([
            'filter' => [
                '=DEAL_ID' => $dealId,
                '=ORDER_ID' => $orderId
            ]
        ])->fetchObject();
    }
    
    
    public static function set($dealId, $orderId) 
    {
        return static::add([
            'DEAL_ID' => $dealId,
            'ORDER_ID' => $orderId
        ]);
    }
}
