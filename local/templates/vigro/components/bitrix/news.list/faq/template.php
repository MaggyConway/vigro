<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>


<section class="container faq">
    <h2>Вопрос&nbsp;&mdash; ответ</h2>

    <div class="faq__accordeon">
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
        <div class="faq__accordeon__item <?=$key==0 ? 'opened' : ''?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <h3>
                <?=$arItem["NAME"]?><span></span>
            </h3>
            <div class="desc">
                <?= $arItem["PREVIEW_TEXT"];?>
            </div>
        </div>

        <?endforeach;?>
    </div>
</section>