<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = array(
   "GROUPS" => array(
        "API" => array(
            "NAME" =>  Loc::getMessage('SILAB_SEARCH_GROUP_API'),
            "SORT" => "500",
        ),
   ),
   "PARAMETERS" => array(
    )
);?>