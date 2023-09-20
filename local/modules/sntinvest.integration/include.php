<?
define('SI_MODULE_NAME', 'sntinvest.integration');
define('SI_MODULE_AUTH_USER', 1);
define('SI_MODULE_ORDER_PROPS_OLD_DEAL', 39);
define('SI_MODULE_ORDER_PROPS_CACHBACK', 40);
define('SI_MODULE_COLLECTION_BASE_NAME', 'Вне серии');

\Bitrix\Main\Loader::registerAutoLoadClasses('sntinvest.integration', array());

Sntinvest\Integration\Container::getInstance(__DIR__. '/bootstrap/container.php');

/**
 * Inludes modules
 */

if (\Bitrix\Main\ModuleManager::isModuleInstalled('crm'))
{
    \Bitrix\Main\Loader::includeModule('crm');
}

\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('iblock');
