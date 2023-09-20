<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('О компании');
?>

    <main class="container page_about">
        <section class="hero">
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                array(
                    "AREA_FILE_SHOW" => "sect",
                    "AREA_FILE_SUFFIX" => "inc",
                ),
                false
            );?>

            <div class="hero--inner">
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
            </div>
        </section>

        <section class="vigro_today">
            <h2><span>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "sect",
                            "AREA_FILE_SUFFIX" => "abouttexttitle",
                        ),
                        false
                    );?></span></h2>

            <div class="row gx-6">
                <div class="col-md-6">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "sect",
                            "AREA_FILE_SUFFIX" => "abouttextleft",
                        ),
                        false
                    );?>
                </div>
                <div class="col-md-6">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "sect",
                            "AREA_FILE_SUFFIX" => "abouttextright",
                        ),
                        false
                    );?>
                </div>
            </div>
        </section>

        <section class="facts">
            <h2>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "sect",
                        "AREA_FILE_SUFFIX" => "aboutfactstitle",
                    ),
                    false
                );?>
                </h2>

            <ul class="row g-6">
                <li class="col-sm-6 col-lg">
                    <div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "sect",
                                "AREA_FILE_SUFFIX" => "aboutfact1",
                            ),
                            false
                        );?>

                    </div>
                </li>
                <li class="col-sm-6 col-lg">
                    <div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "sect",
                                "AREA_FILE_SUFFIX" => "aboutfact2",
                            ),
                            false
                        );?>

                    </div>
                </li>
                <li class="col-sm-6 col-lg">
                    <div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "sect",
                                "AREA_FILE_SUFFIX" => "aboutfact3",
                            ),
                            false
                        );?>

                    </div>
                </li>
                <li class="col-sm-6 col-lg">
                    <div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "sect",
                                "AREA_FILE_SUFFIX" => "aboutfact4",
                            ),
                            false
                        );?>

                    </div>
                </li>
            </ul>
        </section>
    </main>

<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>