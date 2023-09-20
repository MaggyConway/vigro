<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>


<section class="container ideas">
    <h2>Идеи<strong> для&nbsp;кухни</strong></h2>

    <div class="row mb-5">

        <?foreach($arResult["ITEMS"] as $key => $arItem):
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
        <?if($key == 0):?>
        <div class="col-12 col-lg-8 mb-3 mb-md-4 mb-lg-0" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="ideas__image">
                <img
                    src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                    alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                    title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                    loading="lazy"
                />
                <p><?=$arItem["NAME"]?></p>
            </a>
        </div>
        <div class="col-12 col-lg-4 d-flex flex-wrap">
        <?endif;?>
            <?if($key == 1):?>
            <a
                href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
                class="ideas__image mb-3 mb-md-4 align-items-stretch"
                id="<?=$this->GetEditAreaId($arItem['ID']);?>"
            >
                <img
                    src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                    alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                    title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                    loading="lazy"
                />
                <p><?=$arItem["NAME"]?></p>
            </a>
            <?endif;?>
            <?if($key == 2):?>
            <a
                href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
                class="ideas__image align-items-stretch"
                id="<?=$this->GetEditAreaId($arItem['ID']);?>"
            >
                <img
                    src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                    alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                    title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                    loading="lazy"
                />
                <p><?=$arItem["NAME"]?></p>
            </a>
            </div>
            <?endif;?>


        <?endforeach;?>
    </div>

    <!-- <div class="col-7 col-sm-4 col-md-2"> -->
    <a href="/ideas/" class="btn">Смотреть ещё</a>
    <!-- </div> -->
</section>