<?php

namespace Sntinvest\Market\Interfaces;

use Sntinvest\Market\Interfaces\iApi;

interface iExchange 
{
    public function getApi() : iApi;
    public function exchange();
}
