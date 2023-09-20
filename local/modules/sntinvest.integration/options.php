<?

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

Loader::includeModule($module_id);

$aTabs = array(
    array(
        "Настройки",
        "OPTIONS" => array(
            "RebbitMQ настройки",
            array(
                "rebbitmq_addres",
                "RebbitMQ - адрес сервера",
                "",
                array("text")
            ),
            array(
                "rebbitmq_port",
                "RebbitMQ - порт сервера",
                "",
                array("text")
            ),
            array(
                "rebbitmq_user",
                "RebbitMQ - пользователь",
                "",
                array("text")
            ),
            array(
                "rebbitmq_password",
                "RebbitMQ - пароль",
                "",
                array("text")
            ),
            array(
                "rebbitmq_vhost",
                "RebbitMQ - виртуальный хост",
                "",
                array("text")
            ),
            "Настройки ИБ",
            array(
                "product_iblock_id",
                "ID информационного блока товаров s1",
                "",
                array("text")
            ),
            array(
                "collection_iblock_id",
                "ID информационного блока коллекций s1",
                "",
                array("text")
            ),
            array(
                "product_iblock_id_s2",
                "ID информационного блока товаров s2",
                "",
                array("text")
            ),
        )
    )
);

if ($request->isPost() && check_bitrix_sessid()) {

    foreach ($aTabs as $aTab) {

        foreach ($aTab["OPTIONS"] as $arOption) {

            if (!is_array($arOption)) {

                continue;
            }

            if ($arOption["note"]) {

                continue;
            }

            if ($request["apply"]) {

                $optionValue = $request->getPost($arOption[0]);

                if ($arOption[0] == "switch_on") {

                    if ($optionValue == "") {

                        $optionValue = "N";
                    }
                }

                Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
            } elseif ($request["default"]) {

                Option::set($module_id, $arOption[0], $arOption[2]);
            }
        }
    }

    LocalRedirect($APPLICATION->GetCurPage() . "?mid=" . $module_id . "&lang=" . LANG);
}

$tabControl = new CAdminTabControl(
        "tabControl",
        $aTabs
);

$tabControl->Begin();
?>



<form action="<? echo($APPLICATION->GetCurPage()); ?>?mid=<? echo($module_id); ?>&lang=<? echo(LANG); ?>" method="post">

    <?
    foreach ($aTabs as $aTab) {

        if ($aTab["OPTIONS"]) {

            $tabControl->BeginNextTab();

            __AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
        }
    }

    $tabControl->Buttons();
    ?>

    <input type="submit" name="apply" value="<? echo("Применить"); ?>" class="adm-btn-save" />
    <input type="submit" name="default" value="<? echo("По умолчанию"); ?>" />

    <?
    echo(bitrix_sessid_post());
    ?>

</form>

<?
$tabControl->End();
