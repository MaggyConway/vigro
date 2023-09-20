<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Партнерам');
?>


<main class="container page_partners">
    <section>
        <h2><?$APPLICATION->ShowTitle()?></h2>

        <?$APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "breadcrumbs",
                Array(
                "START_FROM" => "0",
                "PATH" => "",
                "SITE_ID" => "s1"
            )
        );?>

        <p class="col-md-8 col-xl-5">
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                array(
                    "AREA_FILE_SHOW" => "sect",
                    "AREA_FILE_SUFFIX" => "inc",
                ),
                false
            );?>
        </p>

        <script data-b24-form="inline/31/wncv42" data-skip-moving="true">
        (function(w,d,u){
        var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);
        var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://crm.sntinvest.ru/upload/crm/form/loader_31_wncv42.js');
        </script>
    </section>
</main>



<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>