<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<main class="container page_ideas">
	<section>
		<h2>Идеи для&nbsp;кухни</h2>

		<ul class="breadcrumbs">
			<li>
				<a href="/" title="Главная">Главная</a>
				<span class="divider"></span>
			</li>
			<li>Идеи для&nbsp;кухни</li>
		</ul>

		<div class="page_ideas__gallery">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				
				// $image = CFile::GetFileArray($arItem["PREVIEW_PICTURE"], false);

				$image = $arItem["PREVIEW_PICTURE"];
				
				$renderImage = CFile::ResizeImageGet($image, array("width" => "684px", "height" => "421px"), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
				
				// echo '<pre>';
				// var_dump($renderImage);
				// echo '</pre>';
				?>

				<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="ideas__image">
					<img src="<?=$renderImage['src']?>" alt="<?=$arItem['NAME']?>" loading="lazy" />
					<p><?=$arItem['NAME']?></p>
				</a>
			<?endforeach;?>
		</div>
	</section>
</main>