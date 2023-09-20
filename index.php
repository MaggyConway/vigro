<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Главная');
?>
    <main>
        <section class="container hero">
            <?
                $APPLICATION->IncludeFile(
                    SITE_DIR . "/include/mainpage_photo.php",
                    Array(),
                    Array(
                        "MODE" => "html")
                );
            ?>

            <div class="hero--inner">
                <h1>
                    <?
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "/include/mainpage_title.php",
                            Array(),
                            Array(
                                "MODE" => "html")
                        );
                    ?>
                </h1>

                <form class="row hero__filter d-none d-sm-flex">
                    <!-- <input class="col" type="text" placeholder="Мойка" />
                    <input class="col" type="text" placeholder="Круглая" /> -->
                    <div class="col">
                        <select>
                            <option value="washing" selected>Мойка</option>
                            <option value="faucet">Смеситель</option>
                        </select>

                        <div class="pseudo_select">
                            <div class="active_label">Мойка</div>
                            <div class="pseudo_select__panel">
                                <a
                                    href="javascript:void(0);"
                                    class="pseudo_select__item"
                                    data-val="washing"
                                    data-url="/shop/kruglye-moyki/"
                                >Мойка</a
                                >
                                <a
                                    href="javascript:void(0);"
                                    class="pseudo_select__item"
                                    data-val="faucet"
                                    data-url="/shop/smesiteli/"
                                >Смеситель</a
                                >
                            </div>
                        </div>
                    </div>

                    <div class="col type">
                        <select>
                            <option value="washing1" selected>Круглая</option>
                            <option value="washing2">Квадратная</option>
                            <option value="washing3">Овальная</option>
                            <option value="washing4">Прямоугольная</option>
                            <option value="washing5">С&nbsp;двумя чашами</option>
                            <option value="washing6">Фигурная</option>
                        </select>

                        <div class="pseudo_select">
                            <div class="active_label">Круглая</div>
                            <div class="pseudo_select__panel">
                                <a
                                    href="javascript:void(0);"
                                    class="pseudo_select__item"
                                    data-val="washing1"
                                    data-url="/shop/kruglye-moyki/"
                                >Круглая</a>
                                <a
                                    href="javascript:void(0);"
                                    class="pseudo_select__item"
                                    data-val="washing2"
                                    data-url="/shop/kvadratnye-moyki/"
                                >Квадратная</a>
                                <a
                                    href="javascript:void(0);"
                                    class="pseudo_select__item"
                                    data-val="washing3"
                                    data-url="/shop/ovalnye-moyki/"
                                >Овальная</a>
                                <a
                                    href="javascript:void(0);"
                                    class="pseudo_select__item"
                                    data-val="washing4"
                                    data-url="/shop/pryamougolnye-moyki/"
                                >Прямоугольная</a>
                                <a
                                    href="javascript:void(0);"
                                    class="pseudo_select__item"
                                    data-val="washing5"
                                    data-url="/shop/moyki-s-dvumya-chashami/"
                                >С&nbsp;двумя чашами</a>
                                <a
                                    href="javascript:void(0);"
                                    class="pseudo_select__item"
                                    data-val="washing6"
                                    data-url="/shop/figurnye-moyki/"
                                >Фигурная</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <a href="/shop/kruglye-moyki/" class="col-auto btn">Найти</a>
                    </div>
                </form>

                <div class="d-sm-none">
                    <a href="/shop/" class="btn">В&nbsp;каталог</a>
                </div>
            </div>
        </section>

        <section class="container kitchen_heart">
            <div class="row justify-content-between">
                <div class="col-12 col-md-6 col-lg-4 d-flex flex-column justify-content-between">
                    <h2>
                        <?
                            $APPLICATION->IncludeFile(
                                SITE_DIR . "/include/kitchen_heart_title.php",
                                Array(),
                                Array(
                                    "MODE" => "html")
                            );
                        ?>
                    </h2>

                    <p class="pb-3 pb-md-0">
                        <?
                            $APPLICATION->IncludeFile(
                                SITE_DIR . "/include/kitchen_heart_text.php",
                                Array(),
                                Array(
                                    "MODE" => "html")
                            );
                        ?>
                    </p>
                </div>
                <div class="col-12 col-md-6 col-lg-7">
                    <?
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "/include/kitchen_heart_photo.php",
                            Array(),
                            Array(
                                "MODE" => "html")
                        );
                    ?>
                </div>
            </div>
        </section>

        <? $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "advantages",
                Array(
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "AJAX_MODE" => "Y",
                    "IBLOCK_TYPE" => "content_vigro",
                    "IBLOCK_ID" => $_ENV['ADVANTAGES_HOMEPAGE_ID'],
                    "NEWS_COUNT" => "5",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "",
                    "FIELD_CODE" => Array("ID"),
                    "PROPERTY_CODE" => Array("VIDEO"),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_LAST_MODIFIED" => "Y",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Преимущества",
                    "PAGER_SHOW_ALWAYS" => "Y",
                    "PAGER_TEMPLATE" => "",
                    "PAGER_DESC_NUMBERING" => "Y",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_BASE_LINK_ENABLE" => "Y",
                    "SET_STATUS_404" => "N",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    "PAGER_BASE_LINK" => "",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => ""
            )
        );?>

        <? /*
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "ideas",
                Array(
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "AJAX_MODE" => "Y",
                    "IBLOCK_TYPE" => "content_vigro",
                    "IBLOCK_ID" => $_ENV['IDEAS_ID'],
                    "NEWS_COUNT" => "3",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "",
                    "FIELD_CODE" => Array("ID"),
                    "PROPERTY_CODE" => Array(""),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_LAST_MODIFIED" => "Y",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Преимущества",
                    "PAGER_SHOW_ALWAYS" => "Y",
                    "PAGER_TEMPLATE" => "",
                    "PAGER_DESC_NUMBERING" => "Y",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_BASE_LINK_ENABLE" => "Y",
                    "SET_STATUS_404" => "N",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    "PAGER_BASE_LINK" => "",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => ""
                )
            );
            
        
    /*    
        if (CModule::IncludeModule("iblock")) :

            $resTags = CIBlockElement::GetList(
                Array("SORT"=>"ASC"), 
                Array("IBLOCK_ID" => $_ENV['IDEAS_ID'], "ACTIVE"=>"Y"), 
                false, false, 
                Array("ID", "NAME", "TAGS"));

            $allTags = [];
            $uniqueTags = [];

            while ($el = $resTags->Fetch()) {
                // echo "<pre>"; var_dump($el); echo "</pre>";
                if(!empty($el["TAGS"])){
                    //$arrayTags[] = $el["TAGS"]; // строки всех тегов через запятую от каждого товара, но в массиве
                    //$allTags .= $el["TAGS"].','; // добавляю запятые между товарами - группами тегов
                    $el["TAGS"] =  explode(',', $el["TAGS"]); // делит запятыми на массив из строк

                    foreach ($el["TAGS"] as $tag) {
                        $tag = trim($tag);
                        $allTags[] = $tag;
                    }
                }
                $uniqueTags = array_unique($allTags);
                
            

                $resColors = CIBlockElement::GetList(
                    Array("SORT"=>"ASC"), 
                    Array("IBLOCK_ID" => $_ENV['IDEAS_ID'], "ACTIVE"=>"Y"), 
                    false, false, 
                    Array("ID", "NAME", "TAGS", "PROPERTY_COLORS"));

                $allColors = [];
                $uniqueColors = [];

                while ($el = $resColors->Fetch()) {
                    if(!empty($el["PROPERTY_COLORS_VALUE"])) {
                        
                        foreach ($el["PROPERTY_COLORS_VALUE"] as $color) {
                            $allColors[] = $color;
                        }
                    }
                }
                $uniqueColors = array_unique($allColors);
        ?>


        <section class="container calc">
            <h2>
                Вдохновитесь &mdash;<br /><strong>подберите идеи для&nbsp;кухни</strong>
            </h2>

            <form class="calc__overview">
                <div class="step step--style active">
                    <h3>Выберите стиль</h3>

                    <ul>
                        <? foreach ($uniqueTags as $tagItem) : ?>

                            <li>
                                <label><input type="checkbox" data-name="<?=$tagItem;?>" /><span></span><?=$tagItem;?></label>
                            </li>

                        <? endforeach; ?>
                    </ul>

                    <button class="btn">Далее</button>
                </div>
                <div class="step step--color">
                    <h3>Выберите цвет</h3>

                    <ul>
                        <? foreach ($uniqueColors as $mini_color) : ?>
                            <li>
                                <img
                                    src="<?=SITE_TEMPLATE_PATH?>/assets/images/washing_colors/<?=$mini_color?>.png"
                                    alt="<?=$mini_color?>"
                                    data-code="<?=$mini_color?>"
                                />
                            </li>
                        <? endforeach; ?>
                    </ul>

                    <button class="btn">Далее</button>
                </div>
                <div class="step step--process">
                    <h3>Подбираем идеи...</h3>
                </div>
                <div class="step step--result"></div>

                <div class="step--result__readmore">Загрузить ещё&nbsp;фото</div>

                <div class="btn restart">Вдохновиться ещё&nbsp;раз</div>

                <div class="calc__progress"><span></span></div>
            </form>
        </section>

        <? 
        endif;
        */
        
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "findcouple",
            Array(
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "AJAX_MODE" => "Y",
                "IBLOCK_TYPE" => "content_vigro",
                "IBLOCK_ID" => $_ENV['FINDCOUPLE_ID'],
                "NEWS_COUNT" => "10",
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_ORDER1" => "DESC",
                "SORT_BY2" => "SORT",
                "SORT_ORDER2" => "ASC",
                "FILTER_NAME" => "",
                "FIELD_CODE" => Array("ID"),
                "PROPERTY_CODE" => Array("WASHING_POINT", "FAUCET_POINT", "WASHING", "FAUCET", "PHOTO"),
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "SET_TITLE" => "N",
                "SET_BROWSER_TITLE" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_LAST_MODIFIED" => "Y",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                "ADD_SECTIONS_CHAIN" => "Y",
                "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "INCLUDE_SUBSECTIONS" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "PAGER_TITLE" => "Преимущества",
                "PAGER_SHOW_ALWAYS" => "Y",
                "PAGER_TEMPLATE" => "",
                "PAGER_DESC_NUMBERING" => "Y",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_BASE_LINK_ENABLE" => "Y",
                "SET_STATUS_404" => "N",
                "SHOW_404" => "N",
                "MESSAGE_404" => "",
                "PAGER_BASE_LINK" => "",
                "PAGER_PARAMS_NAME" => "arrPager",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_ADDITIONAL" => ""
            )
        );?>



        <section class="container hero control">
            <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/control.jpg" alt="control_image" />
            <div class="hero--inner">
                <h2>100% контроль качества</h2>
                <p>Каждое изделие прошло предпродажную проверку качества</p>
                <div class="col-7 col-sm-4">
                    <a href="/100-control/" class="btn mt-5 mt-md-3"
                    >Подробнее</a
                    >
                </div>
            </div>
        </section>

        <? /*
            global $catalog_slider_hit, $catalog_slider_new;

            $catalog_slider_hit = [
                '=PROPERTY_OFFERS_VALUE' => 'Хит продаж'
            ];
            $catalog_slider_new = [
                '=PROPERTY_OFFERS_VALUE' => 'Новинка'
            ];
        ?>

        <section class="container catalog_sliders">
            <ul class="tabs">
                <li class="active" data-type="hit">Хиты</li>
                <li data-type="new">Новинки</li>
            </ul>

            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "catalog_slider",
                array(
                    "SLIDER_TYPE" => "hits",
                    "ACTION_VARIABLE" => "action",
                    "ADD_PICT_PROP" => "-",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "BACKGROUND_IMAGE" => "-",
                    "BASKET_URL" => "/cart/",
                    "BROWSER_TITLE" => "-",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPATIBLE_MODE" => "Y",
                    "CONVERT_CURRENCY" => "N",
                    // "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"OR\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBProp:19:708\",\"DATA\":{\"logic\":\"Equal\",\"value\":6066}}]}",
                    "DETAIL_URL" => "/shop/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_COMPARE" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "sort",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "ENLARGE_PRODUCT" => "PROP",
                    "ENLARGE_PROP" => "-",
                    "FILTER_NAME" => "catalog_slider_hit",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => $_ENV['CATALOG_ID'],
                    "IBLOCK_TYPE" => "shop_vigro",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "LABEL_PROP" => array(),
                    "LABEL_PROP_MOBILE" => array(),
                    "LABEL_PROP_POSITION" => "top-left",
                    "LAZY_LOAD" => "N",
                    "LINE_ELEMENT_COUNT" => "3",
                    "LOAD_ON_SCROLL" => "N",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "PREVIEW_TEXT",
                        2 => "PREVIEW_PICTURE",
                        3 => "DETAIL_TEXT",
                        4 => "DETAIL_PICTURE",
                        5 => "",
                    ),
                    "OFFERS_LIMIT" => "0",
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "",
                    "PAGE_ELEMENT_COUNT" => "8",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array(
                        0 => "BASE",
                    ),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                    "PRODUCT_DISPLAY_MODE" => "N",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
                    "PRODUCT_SUBSCRIPTION" => "N",
                    "PROPERTY_CODE" => ["CDN_IMAGES_LIST", "SANINVEST_ARTICUL", "OFFERS",],
                    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                    "RCM_TYPE" => "personal",
                    "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
                    "SECTION_CODE_PATH" => $_REQUEST["SECTION_CODE_PATH"],
                    "SECTION_ID" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_CODE",
                    "SECTION_URL" => "/shop/#SECTION_CODE_PATH#/",
                    "SECTION_USER_FIELDS" => array(
                        0 => "UF_SHORTNAME",
                        1 => "",
                    ),
                    "SEF_MODE" => "Y",
                    "SEF_RULE" => "/shop/#SECTION_CODE_PATH#/",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "SHOW_CLOSE_POPUP" => "Y",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_FROM_SECTION" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "N",
                    "SLIDER_INTERVAL" => "3000",
                    "SLIDER_PROGRESS" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "COMPONENT_TEMPLATE" => "catalog_slider"
                ),
                false
            ); ?>

            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "catalog_slider",
                array(
                    "SLIDER_TYPE" => "new",
                    "ACTION_VARIABLE" => "action",
                    "ADD_PICT_PROP" => "-",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "BACKGROUND_IMAGE" => "-",
                    "BASKET_URL" => "/cart/",
                    "BROWSER_TITLE" => "-",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPATIBLE_MODE" => "Y",
                    "CONVERT_CURRENCY" => "N",
                    // "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"OR\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBProp:19:708\",\"DATA\":{\"logic\":\"Equal\",\"value\":6066}}]}",
                    "DETAIL_URL" => "/shop/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_COMPARE" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "sort",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "ENLARGE_PRODUCT" => "PROP",
                    "ENLARGE_PROP" => "-",
                    "FILTER_NAME" => "catalog_slider_new",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => $_ENV['CATALOG_ID'],
                    "IBLOCK_TYPE" => "shop_vigro",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "LABEL_PROP" => array(),
                    "LABEL_PROP_MOBILE" => array(),
                    "LABEL_PROP_POSITION" => "top-left",
                    "LAZY_LOAD" => "N",
                    "LINE_ELEMENT_COUNT" => "3",
                    "LOAD_ON_SCROLL" => "N",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "PREVIEW_TEXT",
                        2 => "PREVIEW_PICTURE",
                        3 => "DETAIL_TEXT",
                        4 => "DETAIL_PICTURE",
                        5 => "",
                    ),
                    "OFFERS_LIMIT" => "0",
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "",
                    "PAGE_ELEMENT_COUNT" => "8",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array(
                        0 => "BASE",
                    ),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                    "PRODUCT_DISPLAY_MODE" => "N",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
                    "PRODUCT_SUBSCRIPTION" => "N",
                    "PROPERTY_CODE" => ["CDN_IMAGES_LIST", "SANINVEST_ARTICUL", "OFFERS",],
                    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                    "RCM_TYPE" => "personal",
                    "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
                    "SECTION_CODE_PATH" => $_REQUEST["SECTION_CODE_PATH"],
                    "SECTION_ID" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_CODE",
                    "SECTION_URL" => "/shop/#SECTION_CODE_PATH#/",
                    "SECTION_USER_FIELDS" => array(
                        0 => "UF_SHORTNAME",
                        1 => "",
                    ),
                    "SEF_MODE" => "Y",
                    "SEF_RULE" => "/shop/#SECTION_CODE_PATH#/",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "SHOW_CLOSE_POPUP" => "Y",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_FROM_SECTION" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "N",
                    "SLIDER_INTERVAL" => "3000",
                    "SLIDER_PROGRESS" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "COMPONENT_TEMPLATE" => "catalog_slider"
                ),
                false
            ); ?> 
        </section> */?>

        <div class="container">
            <? $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "articles",
                Array(
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "AJAX_MODE" => "Y",
                    "IBLOCK_TYPE" => "content_vigro",
                    "IBLOCK_ID" => $_ENV['BLOG_ID'],
                    "NEWS_COUNT" => "10",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "",
                    "FIELD_CODE" => Array("ID"),
                    "PROPERTY_CODE" => Array(),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_LAST_MODIFIED" => "Y",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Преимущества",
                    "PAGER_SHOW_ALWAYS" => "Y",
                    "PAGER_TEMPLATE" => "",
                    "PAGER_DESC_NUMBERING" => "Y",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_BASE_LINK_ENABLE" => "Y",
                    "SET_STATUS_404" => "N",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    "PAGER_BASE_LINK" => "",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "CUSTOM_TITLE" => "Полезные статьи"
                )
            );?>
        </div>

        <?$APPLICATION->IncludeComponent(
            "bitrix:sender.subscribe",
            "homepage_subscribe",
            Array(
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CONFIRMATION" => "Y",
                "HIDE_MAILINGS" => "N",
                "SET_TITLE" => "N",
                "SHOW_HIDDEN" => "N",
                "USER_CONSENT" => "Y",
                "USER_CONSENT_ID" => "0",
                "USER_CONSENT_IS_CHECKED" => "Y",
                "USER_CONSENT_IS_LOADED" => "N",
                "USE_PERSONALIZATION" => "Y"
            )
        );?>

        

        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "faq",
            Array(
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "AJAX_MODE" => "Y",
                "IBLOCK_TYPE" => "content_vigro",
                "IBLOCK_ID" => $_ENV['FAQ_ID'],
                "NEWS_COUNT" => "20",
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_ORDER1" => "DESC",
                "SORT_BY2" => "SORT",
                "SORT_ORDER2" => "ASC",
                "FILTER_NAME" => "",
                "FIELD_CODE" => Array("ID"),
                "PROPERTY_CODE" => Array(),
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "SET_TITLE" => "N",
                "SET_BROWSER_TITLE" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_LAST_MODIFIED" => "Y",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                "ADD_SECTIONS_CHAIN" => "Y",
                "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "INCLUDE_SUBSECTIONS" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "PAGER_TITLE" => "Преимущества",
                "PAGER_SHOW_ALWAYS" => "Y",
                "PAGER_TEMPLATE" => "",
                "PAGER_DESC_NUMBERING" => "Y",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_BASE_LINK_ENABLE" => "Y",
                "SET_STATUS_404" => "N",
                "SHOW_404" => "N",
                "MESSAGE_404" => "",
                "PAGER_BASE_LINK" => "",
                "PAGER_PARAMS_NAME" => "arrPager",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_ADDITIONAL" => ""
            )
        );?>

    </main>

<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>