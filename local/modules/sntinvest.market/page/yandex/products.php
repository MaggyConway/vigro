<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Sntinvest\Market\Factory\YandexMarketFactory;
use Sntinvest\Market\Market;
use Sntinvest\CRest\Logger;

if (\Bitrix\Main\Loader::includeModule("sntinvest.market")
    && \Bitrix\Main\Loader::includeModule('sntinvest.crest'))
{
    Logger::getInstance()
        ->setFile('market_sku_' . date("Y_m_d"))
        ->removeFile('market_sku')
        ->setDebug(Logger::DEBUG_FILE);


    //Условно в Factory можно задать storge
    $factory = new YandexMarketFactory();

    //Передаем на выгрузку фабрику
    $market = new Market($factory);

    //выгружаем
    $market->products();
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

