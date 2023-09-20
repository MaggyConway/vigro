<?php

namespace Sntinvest\Market\Exchange\Wb;

use Sntinvest\Market\Interfaces\iExchange;
use Sntinvest\Market\Interfaces\iApi;
use Sntinvest\Market\Api\WbApi;

/**
 * Description of OzonProductsExchange
 *
 * @author dimay
 */
class WbStatusExchange implements iExchange
{
    private $api;
    private $params;

    public function __construct($params)
    {
        $this->api = $this->getApi();
        $this->params = $params;
    }
    
    public function getApi(): iApi 
    {
        return new WbApi();
    }

    
    public function exchange()
    {
        

    }
}
