<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>


<section class="news">
    <h2><?=$arParams['CUSTOM_TITLE']?></h2>

    <div class="news__slider">

        <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction(
            $arItem['ID'],
            $arItem['EDIT_LINK'],
            CIBlock::GetArrayByID(
                $arItem["IBLOCK_ID"],
                "ELEMENT_EDIT"
            )
        );
        $this->AddDeleteAction(
            $arItem['ID'],
            $arItem['DELETE_LINK'],
            CIBlock::GetArrayByID(
                $arItem["IBLOCK_ID"],
                "ELEMENT_DELETE"),
            array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
        );
        /*echo "<pre>";
        var_dump($arItem['DISPLAY_PROPERTIES']);
        echo "</pre>";*/
        ?>

        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <img
                src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
            />
            <p><?=$arItem["NAME"]?></p>
        </a>

        <?endforeach; ?>
    </div>

    <a href="/blog/" class="btn">Смотреть все</a>
</section>
