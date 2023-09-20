<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Repositories\MutualSettlements;

use Sntinvest\Integration\Repositories\Repository;

use Sntinvest\Integration\Repositories\MutualSettlements\OrderRepository;
use Bitrix\Main\Type\Date;
use Bitrix\Sale\PaySystem\Manager;

/**
 * Description of ApplicationRepository
 *
 * @author dimay
 */
class PaymentRepository extends Repository
{
    private $order;
    
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
        
        $collection = $entry->getPaymentCollection();
        
        $paySystemService = Manager::getObjectById(1);
        
        foreach ($collection as $pay)
        {
            if ($pay->getField('XML_ID') === $data['XML_ID'])
            {
                $payment = $pay;
                break;
            }
        }
        
        if (!isset($payment) || is_null($payment))
        {
            $payment = $collection->createItem();
            
            $payment->setFields([
                'XML_ID' => $data['XML_ID'],
                'ACCOUNT_NUMBER' => $data['NUMBER'],
                'DATE_PAY_BEFORE' => Date::createFromPhp(new \DateTime($data['DATE_PAY_BEFORE'])),
                'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
                'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
            ]);
        }    
        
        if (isset($payment) && !is_null($payment))
        {
            $payment->setFields([
                'SUM' => $data['SUM'],
                'PAID' => $data['STATUS'],
                'DATE_PAID' => Date::createFromPhp(new \DateTime($data['DATE_PAY'])),
            ]);
        }  
    }
}
