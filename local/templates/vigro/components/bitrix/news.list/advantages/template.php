<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<section class="container advantages">
    <h2>
        Превратите использование мойки
        <br />
        <strong>в&nbsp;удовольствие</strong>
    </h2>

    <div class="advantages__slider pb-4 pb-sm-5">
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
        <div id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="row gx-0 d-flex flex-column-reverse flex-lg-row">
                <div class="col-12 col-lg-7">
                    <? if($arItem['DISPLAY_PROPERTIES']['VIDEO']['DISPLAY_VALUE']): ?>
                        <?=$arItem['DISPLAY_PROPERTIES']['VIDEO']['DISPLAY_VALUE']?>
                        <iframe
                            class="embed-responsive-item"
                            src="<?= $arItem["VIDEO"]?>"
                            frameborder="0"
                            allowfullscreen=""
                        ></iframe>
                    <?else:?>
                        <img
                            src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                            alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                            title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                        />
                    <?endif;?>
                </div>
                <div class="col-12 col-lg-5 d-flex flex-column justify-content-center">
                    <h3 class="mb-md-4"><?=$arItem["NAME"]?></h3>
                    <p class="mb-4 d-none d-md-block">
                        <?= $arItem["PREVIEW_TEXT"];?>
                    </p>
                    <a href="/shop/" class="btn d-none d-md-flex">Перейти в&nbsp;каталог</a>
                </div>
            </div>
        </div>
        <?endforeach;?>
    </div>
</section>