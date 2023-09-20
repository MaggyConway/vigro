<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="mobile_filter_panel"></div>
<footer class="footer">
    <div class="container">
        <div class="row justify-content-sm-center justify-content-lg-start justify-content-xl-between">
            <ul class="d-none d-xl-block col-xl-4">
                <li><h3>Продукция</h3></li>
                <li><a href="/shop/kruglye-moyki/">Круглые мойки</a></li>
                <li><a href="/shop/smesiteli/">Смесители</a></li>
                <li><a href="/shop/figurnye-moyki/">Фигурные мойки</a></li>
                <li><a href="/shop/kvadratnye-moyki/">Квадратные мойки</a></li>
                <li><a href="/shop/pryamougolnye-moyki/">Прямоугольные мойки</a></li>
                <li><a href="/shop/moyki-s-dvumya-chashami/">Мойки с&nbsp;двумя чашами</a></li>
                <li><a href="/shop/ovalnye-moyki/">Овальные мойки</a></li>
            </ul>
            <ul class="col-12 col-md-6 col-lg-4">
                <li class="d-none d-md-block"><h3>Компания</h3></li>
                <li><a href="/contacts/">Контакты</a></li>
                <li><a href="/about/">О&nbsp;компании</a></li>
                <li class="d-none d-md-block">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH"=> "/include/phone.php"
                        ),
                        false
                    );?>
                </li>
                <li><a href="/partners/">Партнерам</a></li>
                <li><a href="/services/">Сервисные центры</a></li>
            </ul>
            <ul class="col-3 col-lg-2 d-none d-md-block">
                <li><h3>Полезное</h3></li>
                <li><a href="/ideas/">Идеи для&nbsp;кухни</a></li>
                <li><a href="/blog/">Блог</a></li>
            </ul>
        </div>
        <div class="row">
            <p class="copyright">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH"=> "/include/copyrights.php"
                    ),
                    false
                );?>
            </p>
        </div>
    </div>
</footer>
</div><!-- end of .wrapper -->


        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("assets/jquery.min.js"));?>
        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("assets/slick-1.8.1/slick/slick.min.js"));?>
        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("assets/UItoTop-jQuery-Plugin/js/easing.js"));?>
        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("assets/UItoTop-jQuery-Plugin/js/jquery.ui.totop.min.js"));?>

        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("js/sliders.js"));?>
        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("js/functions.js"));?>
        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("js/select.js"));?>
        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("js/main_menu.js"));?>
        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("js/homepage_calc.js"));?>
        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("js/catalog_sorting.js"));?>
        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("js/hero_dropdowns.js"));?>
        <?php $APPLICATION->AddHeadScript($APPLICATION->GetTemplatePath("js/scroll.js"));?>
    </body>
</html>