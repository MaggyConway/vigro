<?php

require_once __DIR__ . '/src/Autoloader.php';

Sntinvest\Market\Autoloader::register();

define('SNTINVEST_MARKET_ROOT_DIR', __DIR__);

define('YANDEX_CLIENT_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "YANDEX_CLIENT_ID"));
define('YANDEX_TOKEN', \Bitrix\Main\Config\Option::get('sntinvest.market', "YANDEX_TOKEN"));

// Может быть множественным
define('YANDEX_COMPAIGN_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "YANDEX_COMPAIGN_ID"));

// Настройки каталога
define('BITRIXAPI_CATALOG_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "CATALOG_ID"));
define('BITRIXAPI_CATALOG_OFFER_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "CATALOG_ID"));
define('BITRIXAPI_PROPERTY_SEACRH', \Bitrix\Main\Config\Option::get('sntinvest.market', "PROPERTY_SEACRH"));

define('OZON_CLIENT_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "OZON_CLIENT_ID"));
define('OZON_API_KEY', \Bitrix\Main\Config\Option::get('sntinvest.market', "OZON_API_KEY"));

define('DEAL_OZON_ORDER_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "DEAL_OZON_ORDER_ID"));
define('DEAL_OZON_SOURCE_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "DEAL_OZON_SOURCE_ID"));
define('DEAL_OZON_STAGE_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "DEAL_OZON_STAGE_ID"));
define('DEAL_OZON_CONTACT_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "DEAL_OZON_CONTACT_ID"));
define('DEAL_OZON_COMPANY_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "DEAL_OZON_COMPANY_ID"));
define('CONTACT_OZON_SOURCE_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "CONTACT_OZON_SOURCE_ID"));

define('DEAL_YANDEX_ORDER_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "DEAL_YANDEX_ORDER_ID"));
define('DEAL_YANDEX_SOURCE_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "DEAL_YANDEX_SOURCE_ID"));
define('DEAL_YANDEX_STAGE_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "DEAL_YANDEX_STAGE_ID"));
define('DEAL_YANDEX_CONTACT_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "DEAL_YANDEX_CONTACT_ID"));
define('DEAL_YANDEX_COMPANY_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "DEAL_YANDEX_COMPANY_ID"));
define('CONTACT_YANDEX_SOURCE_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "CONTACT_YANDEX_SOURCE_ID"));


define('ORDER_BITRIXAPI_SHIPMENT_STAGE_NEW', \Bitrix\Main\Config\Option::get('sntinvest.market', "ORDER_BITRIXAPI_SHIPMENT_STAGE_NEW"));
define('ORDER_BITRIXAPI_STATUS_NEW', \Bitrix\Main\Config\Option::get('sntinvest.market', "ORDER_BITRIXAPI_STATUS_NEW"));

define('ORDER_BITRIXAPI_SHIPMENT_STAGE_LOSE', \Bitrix\Main\Config\Option::get('sntinvest.market', "ORDER_BITRIXAPI_SHIPMENT_STAGE_LOSE"));
define('ORDER_BITRIXAPI_STATUS_LOSE', \Bitrix\Main\Config\Option::get('sntinvest.market', "ORDER_BITRIXAPI_STATUS_LOSE"));

define('ORDER_BITRIXAPI_SHIPMENT_STAGE_WON', \Bitrix\Main\Config\Option::get('sntinvest.market', "ORDER_BITRIXAPI_SHIPMENT_STAGE_WON"));
define('ORDER_BITRIXAPI_STATUS_WON', \Bitrix\Main\Config\Option::get('sntinvest.market', "ORDER_BITRIXAPI_STATUS_WON"));

define('ORDER_BITRIXAPI_SHIPMENT_STAGE_WORK', \Bitrix\Main\Config\Option::get('sntinvest.market', "ORDER_BITRIXAPI_SHIPMENT_STAGE_WORK"));
define('ORDER_BITRIXAPI_STATUS_WORK', \Bitrix\Main\Config\Option::get('sntinvest.market', "ORDER_BITRIXAPI_STATUS_WORK"));

define('BITRIXAPI_SITE_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "BITRIXAPI_SITE_ID"));
define('BITRIXAPI_USER_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "BITRIXAPI_USER_ID"));
define('BITRIXAPI_RESPONSIBLE_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "BITRIXAPI_RESPONSIBLE_ID"));
define('BITRIXAPI_ORDER_PLAYMENT_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "BITRIXAPI_ORDER_PLAYMENT_ID"));
define('BITRIXAPI_ORDER_DELIVERY_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "BITRIXAPI_ORDER_DELIVERY_ID"));
define('BITRIXAPI_ORDER_PERSON_TYPE_ID', \Bitrix\Main\Config\Option::get('sntinvest.market', "BITRIXAPI_ORDER_PERSON_TYPE_ID"));

define('OZON_CONTACT_ADDRESS', \Bitrix\Main\Config\Option::get('sntinvest.market', "OZON_CONTACT_ADDRESS"));
define('OZON_CONTACT_PHONE', \Bitrix\Main\Config\Option::get('sntinvest.market', "OZON_CONTACT_PHONE"));
define('OZON_CONTACT_EMAIL', \Bitrix\Main\Config\Option::get('sntinvest.market', "OZON_CONTACT_EMAIL"));
define('MARKET_STORAGE', \Bitrix\Main\Config\Option::get('sntinvest.market', "MARKET_STORAGE"));
define('OZON_STORAGE_SELLER', \Bitrix\Main\Config\Option::get('sntinvest.market', "OZON_STORAGE_SELLER"));
define('OZON_STORAGE_MARKET', \Bitrix\Main\Config\Option::get('sntinvest.market', "OZON_STORAGE_MARKET"));
define('ORDER_PERSON_PROP_DEALID', \Bitrix\Main\Config\Option::get('sntinvest.market', "BITRIXAPI_ORDER_PERSON_PROP_DEALID"));
define('MARKET_FINANCES', \Bitrix\Main\Config\Option::get('sntinvest.market', "MARKET_FINANCES"));
