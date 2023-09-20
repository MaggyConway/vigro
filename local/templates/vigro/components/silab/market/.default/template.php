<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="detail_block marketplaces">
    
    <div class="d-flex" style="max-height: 60px;">
        <?if (isset($arResult['MARKET_WB_LINK']) && !empty($arResult['MARKET_WB_LINK'])):?>
            <div class="me-3">
                <a href="<?=$arResult['MARKET_WB_LINK']?>" target="_blank">
                    <img src="/local/templates/vigro/assets/images/wb.svg" alt="wildberries" />
                </a>
            </div>
        <?endif;?>
        
        <?if (isset($arResult['MARKET_OZON_LINK']) && !empty($arResult['MARKET_OZON_LINK'])):?>
            <div class="me-3">
                <a href="<?=$arResult['MARKET_OZON_LINK']?>" target="_blank">
                    <img src="/local/templates/vigro/assets/images/ozon.svg" alt="ozon" />
                </a>
            </div>
        <?endif;?>
        
        <?if (isset($arResult['MARKET_YANDEX_LINK']) && !empty($arResult['MARKET_YANDEX_LINK'])):?>
            <div class="me-3">
                <a href="<?=$arResult['MARKET_YANDEX_LINK']?>" target="_blank">
                    <img src="/local/templates/vigro/assets/images/ya_market.svg" alt="yandex market" />
                </a>
            </div>
        <?endif;?>
    </div>
</div>