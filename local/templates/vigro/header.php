<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?=SITE_CHARSET?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <? $APPLICATION->ShowMeta("keywords")?>
    <? $APPLICATION->ShowMeta("description")?>

    <? $APPLICATION->SetAdditionalCss($APPLICATION->GetTemplatePath("assets/bootstrap-5.0.1-dist/css/bootstrap-grid.min.css")); ?>
    <? $APPLICATION->SetAdditionalCss($APPLICATION->GetTemplatePath("assets/slick-1.8.1/slick/slick-theme.css")); ?>
    <? $APPLICATION->SetAdditionalCss($APPLICATION->GetTemplatePath("assets/slick-1.8.1/slick/slick.css")); ?>
    <? $APPLICATION->SetAdditionalCss($APPLICATION->GetTemplatePath("assets/UItoTop-jQuery-Plugin/css/ui.totop.css")); ?>
    <? $APPLICATION->SetAdditionalCss($APPLICATION->GetTemplatePath("css/app.css")); ?>

    <title><? $APPLICATION->ShowTitle(); ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <? $APPLICATION->ShowHead(); ?>

</head>

<body <?=($APPLICATION->GetCurPage(false) === '/') ? 'class="homepage"' : ''?>>
    <div id="panel">
        <? $APPLICATION->ShowPanel(); ?>
    </div>

<!-- start of .wrapper -->
<div class="wrapper">

    <header class="container pt-4 pt-sm-3 header">
        <div class="row justify-content-between mb-4 d-none d-sm-flex">
            <?
                $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "header_top",
                    Array(
                        "ROOT_MENU_TYPE" => "header_top",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "",
                        "USE_EXT" => "N"
                    )
                );
            ?>
            <div class="col-md d-none d-md-flex justify-content-end">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH"=> "/include/phone.php"
                    ),
                    false
                ); ?>
            </div>
        </div>
    <div class="row justify-content-between mt-md-4 gy-md-4 gy-lg-0">
        <div class="col-md-12 col-lg-8 col-xl row justify-content-between justify-content-lg-start flex-lg-nowrap">
            <a href="/" class="col-auto">
                <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/logo.svg" alt="logo" class="header__logo" />
            </a>

            <?
            $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "header_main",
                Array(
                    "ROOT_MENU_TYPE" => "header_main",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "",
                    "USE_EXT" => "N"
                )
            );
            ?>

            <div id="mobile_menu_trigger" class="col-auto d-md-none">
                <span>Меню</span>
            </div>

        </div>
        <div class="col-md-10 col-lg-3 col-xl-4 d-none d-md-block">
            <?
                $APPLICATION->IncludeComponent(
                    "silab:search",
                    "",
                    []
                );
            ?>
        </div>
        <div class="col header__wishlist p-0 mx-md-3 d-none d-md-block">
            <a href="/wishlist/"></a>
        </div>
    </div>
   
    <div id="main_menu_panel" class="container">
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list", 
            "catalog_sections_desktop", 
            array(
                "ADD_SECTIONS_CHAIN" => "Y",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COUNT_ELEMENTS" => "N",
                "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                "FILTER_NAME" => "sectionsFilter",
                "IBLOCK_ID" => $_ENV['CATALOG_ID'],
                "IBLOCK_TYPE" => "shop_vigro",
                "SECTION_CODE" => "",
                "SECTION_FIELDS" => array(
                    0 => "",
                    1 => "",
                ),
                "SECTION_ID" => "",
                "SECTION_URL" => "",
                "SECTION_USER_FIELDS" => array(
                    0 => "",
                    1 => "",
                ),
                "SHOW_PARENT_NAME" => "Y",
                "TOP_DEPTH" => "1",
                "VIEW_MODE" => "LIST",
                "COMPONENT_TEMPLATE" => "catalog_sections"
            ),
            false
        );?>
    </div>

    <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list", 
            "catalog_sections_mobile", 
            array(
                "ADD_SECTIONS_CHAIN" => "Y",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COUNT_ELEMENTS" => "N",
                "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                "FILTER_NAME" => "sectionsFilter",
                "IBLOCK_ID" => $_ENV['CATALOG_ID'],
                "IBLOCK_TYPE" => "shop_vigro",
                "SECTION_CODE" => "",
                "SECTION_FIELDS" => array(
                    0 => "",
                    1 => "",
                ),
                "SECTION_ID" => "",
                "SECTION_URL" => "",
                "SECTION_USER_FIELDS" => array(
                    0 => "",
                    1 => "",
                ),
                "SHOW_PARENT_NAME" => "Y",
                "TOP_DEPTH" => "1",
                "VIEW_MODE" => "LIST",
                "COMPONENT_TEMPLATE" => "catalog_sections"
            ),
            false
        );?>
</header>