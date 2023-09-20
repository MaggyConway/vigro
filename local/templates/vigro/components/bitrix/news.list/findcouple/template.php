<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (CModule::IncludeModule("iblock")) {
?>

<section class="container find_couple">
    <h2 class="">Найди<strong> свою&nbsp;пару</strong></h2>

    <div class="find_couple__slider">
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


        
        // TODO: Сделать получение товаров из каталога
        
        $WASHING_ID = $arItem['PROPERTIES']['WASHING']['VALUE'];
        $FAUCET_ID = $arItem['PROPERTIES']['FAUCET']['VALUE'];

        $washingArr = [];
        $faucetArr = [];

        $arSelectWashing = Array("ID", "NAME", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID");
        $arFilterWashing = Array("IBLOCK_TYPE"=>"shop_vigro", "IBLOCK_ID"=>$_ENV['CATALOG_ID'], "ID"=>intval($WASHING_ID), "ACTIVE"=>"Y");
        $resWashing = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilterWashing, false, false, $arSelectWashing);
        while ($ob = $resWashing->GetNextElement()) { 
            $arFields = $ob->GetFields();
            // $arProps = $ob->GetProperties();
            $washingArr[] = $arFields;
        }

        $arSelectFaucet = Array("ID", "NAME", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID");
        $arFilterFaucet = Array("IBLOCK_TYPE"=>"shop_vigro", "IBLOCK_ID"=>$_ENV['CATALOG_ID'], "ID"=>intval($FAUCET_ID), "ACTIVE"=>"Y");
        $resFaucet = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilterFaucet, false, false, $arSelectFaucet);
        while ($ob = $resFaucet->GetNextElement()) { 
            $arFields = $ob->GetFields();
            // $arProps = $ob->GetProperties();
            $faucetArr[] = $arFields;
        }

        $washingArr = $washingArr[0];
        $faucetArr = $faucetArr[0];

        $washingArticul = explode(' ', $washingArr['NAME'])[0];
        $faucetArticul = explode(' ', $faucetArr['NAME'])[0];
        ?>
        
        <div class="find_couple__slider__map" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <img
                src="<?= $arItem['DISPLAY_PROPERTIES']['PHOTO']['FILE_VALUE']['SRC'] ?>"
                alt="<?= $arItem["PREVIEW_PICTURE"]["NAME"] ?>"
                title="<?= $arItem["PREVIEW_PICTURE"]["NAME"] ?>"
                loading="lazy"
            />

            <ul class="find_couple__slider__tags">
                <li>
                    <a href="<?=$washingArr['DETAIL_PAGE_URL']?>"
                       target="_blank"
                       data-product-id="<?=$washingArr['ID']?>">
                       Мойка: <?=$washingArticul?>&nbsp;>
                    </a>
                </li>
                <li>
                    <a href="<?=$faucetArr['DETAIL_PAGE_URL']?>"
                       target="_blank"
                       data-product-id="<?=$faucetArr['ID']?>">
                       Смеситель: <?=$faucetArticul?>&nbsp;>
                    </a>
                </li>
            </ul>

            <?/*<a
                href="<?=$faucetArr['DETAIL_PAGE_URL']?>"
                target="_blank"
                class="find_couple__slider__map__item"
                style="<?=$arItem['DISPLAY_PROPERTIES']["FAUCET_POINT"]["VALUE"]?>"
            >
                <span class="map--label"></span>
                <div class="find_couple__slider__map__item--desc">
                    <p><?=$faucetArr['ID']?> -> <?=$faucetArr['NAME']?></p>
                </div>
            </a>

            <a
                href="<?=$washingArr['DETAIL_PAGE_URL']?>"
                target="_blank"
                class="find_couple__slider__map__item"
                style="<?=$arItem['DISPLAY_PROPERTIES']["WASHING_POINT"]["VALUE"]?>"
            >
                <span class="map--label"></span>
                <div class="find_couple__slider__map__item--desc">
                    <p><?=$washingArr['ID']?> -> <?=$washingArr['NAME']?></p>
                </div>
            </a>*/?>
        </div>
        <?endforeach;?>
    </div>
</section>

<?}?>