<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<main class="container page_blog">
	<section class="page_blog__gallery">
		<h2><?$APPLICATION->ShowTitle()?></h2>

		<? $APPLICATION->IncludeComponent(
			"bitrix:breadcrumb",
			"breadcrumbs",
			Array(
				"START_FROM" => "0",
				"PATH" => "",
				"SITE_ID" => "s2"
			)
		); ?>
		

		<div class="row flex-wrap gx-6 gy-7">
			<? foreach ($arResult['ITEMS'] as $key => $item) { ?>
				<a href="<?=$item['DETAIL_PAGE_URL']?>" class="page_blog__gallery__item col-12 col-md-6 col-lg-4">
					<img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="<?=$item['NAME']?>" />
					<p><?=$item['NAME']?></p>
				</a>
			<?}?>
		</div>
	</section>
</main>


<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>