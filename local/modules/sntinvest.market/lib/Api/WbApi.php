<?php

namespace Sntinvest\Market\Api;
use Bitrix\Main\Config\Option;
use Sntinvest\Market\Interfaces\iApi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class WbApi implements iApi 
{
    private $client;
    
    public const API_URL = 'https://suppliers-api.wildberries.ru';
    
    public function __construct() {
        $this->client = new Client([
            'headers' => [
                'Authorization' => Option::get('sntinvest.market', 'wb_token'),
                'Content-Type' => 'application/json'
            ],
        ]);
    }
    
    protected function sendRequest(string $method, string $url, array $params = array()) : array
    {
        try 
        {
            $params['id'] = "1";
            $params['jsonrpc'] = "2.0";
            
            $respoce = $this->client->request($method, self::API_URL . $url, [
                'json' => $params,
            ])->getBody()->getContents();
        }
        catch (ClientException $ex) 
        {
            $respoce = $ex->getResponse()->getBody()->getContents();
            
        }
        finally 
        {
            $result = json_decode($respoce, 1);    
        }
        
        return $result;
    }

    /**
     * Позволяет получить массив карточек товаров, удовлетворяющих фильтру и 
     * с указанной сортировкой. order - порядок отображения карточек.
     * Может принимать значения asc или desc.sort - какие columns и с какими 
     * excludedValues исключить.find - поиск карточке с определённым 
     * search(значением) в определённом columns.query позволяет получать не 
     * все карточки сразу: limit - сколько карточек максимум вывести, 
     * offset - сколько карточек от самой первой пропустить.
     * 
     * @see https://suppliers-api.wildberries.ru/swagger/index.html#/Card/post_card_list
     * 
     * TODO: functions params
     */
    public function cardList($limit = 1000, $offset = 0)
    {
        $arParams = [
            "query" => [
                "limit" => $limit,
                "offset" => $offset,
            ]
        ];

        $result = $this->sendRequest('POST', '/card/list', [
            'params' => $arParams,
        ]);
        
        if (count($result['result']['cards']) < intval($result['result']['cursor']['total']))
        {
            $arItems = $result['result']['cards'];
            
            $total = intval($result['result']['cursor']['total']);
            
            $pages = ceil($total / $limit);

            for($i=2; $i <= $pages; $i++)
            {
                $offset += $limit;
                
                $arParams['query']['offset'] = $offset;
                
                $resultNext = $this->sendRequest('POST', '/card/list', [
                    'params' => $arParams,
                ]);
                
                if (is_array($resultNext['result']['cards']) && count($resultNext['result']['cards']) > 0)
                {
                    $arItems = array_merge($arItems, $resultNext['result']['cards']);
                }
            }
            
            $result['result']['cards'] = $arItems;
        }

        return $result;
    }

}
