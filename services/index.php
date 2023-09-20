<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Сервисные центры');
?>


<main class="container page_service_centres">
    <section class="row gx-6">
        <div class="col-xl-6">
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

            <p>
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
        </div>
        <div class="col-xl-6">
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Afae7abd31e99efdcf3dbde092c90bba7d59788ff1de30b784ab1a66c665f1a87&amp;source=constructor" width="100%" height="328" frameborder="0"></iframe>
        </div>
    </section>
</main>

<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
