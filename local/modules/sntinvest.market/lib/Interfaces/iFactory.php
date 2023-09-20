<?php

namespace Sntinvest\Market\Interfaces;

use Sntinvest\Market\Interfaces\iExchange;

interface iFactory 
{
    public function products($params) : iExchange;
    public function status($params) : iExchange;
    public function sku($params) : iExchange;
}
