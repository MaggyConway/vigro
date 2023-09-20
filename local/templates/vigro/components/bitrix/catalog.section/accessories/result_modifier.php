<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$arID = array();
foreach ($arResult['ITEMS'] as $arItem) {
    $arID[] = $arItem['ID'];
}

$arOrder = array("SORT" => "ASC");
$arFilter = array(
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'ACTIVE'    => 'Y',
    'ID'        => $arID,
);

$arSelect = array(
    'ID',
    'CODE',
    'IBLOCK_ID',
    'DETAIL_PAGE_URL',
);

$dbRes = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
while ($arIt = $dbRes->GetNext()) {
    $arRes[$arIt['ID']] = $arIt['DETAIL_PAGE_URL'];
}


foreach ($arResult['ITEMS'] as &$arItem) {
    $arItem['DETAIL_PAGE_URL'] = $arRes[$arItem['ID']];
}