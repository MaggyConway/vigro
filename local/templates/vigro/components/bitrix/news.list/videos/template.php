<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<section class="videos">
	<h2>Посмотрите видео</h2>
	<div class="videos--inner">

<? foreach ($arResult["ITEMS"] as $arItem) : ?>
<?
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
$path = CFile::GetPath($arItem['PROPERTIES']['VIDEOFILE']['VALUE']);
// echo '<pre>'; var_dump($path); echo '</pre>';
?>

	<div class="videos__item sleep">
		<video src="<?=$path?>" width="100%" height="100%" poster="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"></video>
	</div>

<? endforeach; ?>
</div>
</section>