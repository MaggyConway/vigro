<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

//echo '<pre>';
// var_dump($arResult["PROPERTIES"]["CATALOG_ITEMS"]["VALUE"]);
//echo '</pre>';
?>

<div class="container page_ideas">
	<section class="hero p-0">
		<img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="idea_hero_image" loading="lazy" />

		<div class="hero--inner">
			<a href="/ideas/" class="btn btn_back"
				>К&nbsp;списку идей</a
			>
			<h1><?=$arResult['NAME']?></h1>
		</div>
	</section>

	<section class="find_couple">
		<? echo $arResult["PROPERTIES"]["SLIDER_TITLE"]["~VALUE"]["TEXT"]; ?>

		<div class="find_couple__slider">
			<? foreach ($arResult["PROPERTIES"]["SLIDER_PHOTOS"]["VALUE"] as $key => $photo) {

				$image = CFile::GetFileArray($photo, false);

				$renderImage = CFile::ResizeImageGet($image, array("width" => "805px", "height" => "488px"), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

				// echo '<pre>';
				// var_dump($renderImage);
				// echo '</pre>';

			?>

				<div class="find_couple__slider__map">
					<img
						src="<?=$renderImage['src']?>"
						alt="couple_photo"
						loading="lazy"
					/>
				</div>
			<?}?>
		</div>

		<?=$arResult["PROPERTIES"]["SLIDER_TEXT"]["~VALUE"]["TEXT"]?>
	</section>

	<?
	if($arResult["PROPERTIES"]["CATALOG_ITEMS"]["VALUE"]) : ?>
	<section class="catalog_sliders">
		<h2>Для&nbsp;этого стиля подойдут</h2>

		<div class="catalog_slider pb-4 pb-sm-5">
			<?
			$binded_items = [];
			foreach ($arResult["PROPERTIES"]["CATALOG_ITEMS"]["VALUE"] as $key => $item_id) {
				$arSelect = array("ID", "NAME", "PREVIEW_PICTURE", "CATALOG_GROUP_1", "DETAIL_PAGE_URL", "PROPERTY_STICKER", "PROPERTY_CDN_IMAGES_LIST", "PROPERTY_SANINVEST_ARTICUL");
				$arFilter = array("IBLOCK_TYPE" => 'shop_vigro', "IBLOCK_ID" => $_ENV['CATALOG_ID'], "ID" => $item_id);
				$res = CIBlockElement::GetList(array("SORT" => "ASC"), $arFilter, false, false, $arSelect);
				while ($ob = $res->GetNextElement()) {
					$binded_items[] = $ob->GetFields();
				}
			}
			
			foreach ($binded_items as $key => $item) {
				// echo '<pre>'; var_dump($item['PROPERTY_CDN_IMAGES_LIST_VALUE']); echo '</pre>';
				$cdnImagesList = $item['PROPERTY_CDN_IMAGES_LIST_VALUE'];
				$articul = $item['PROPERTY_SANINVEST_ARTICUL_VALUE'];

				if (\Bitrix\Main\Loader::includeModule('silab.sitecore')) {
					$images = \Silab\SiteCore\Repositories\ProductRepository::ConvertImagePath($cdnImagesList, $articul);
				}

				$image = array_shift($images);

				if(empty($cdnImagesList)) {
					$image = SITE_TEMPLATE_PATH.'/assets/images/no-image.png';
				}

				?>
				<div>
					<div class="catalog_item" data-sticker="<?=$item['PROPERTY_STICKER_VALUE']?>">
						<a href="<?=$item['DETAIL_PAGE_URL']?>">
							<img
								src="<?=$image?>"
								alt="<?=$item['NAME']?>"
							/>
						</a>
						<p class="catalog_item__title">
							<a href="<?=$item['DETAIL_PAGE_URL']?>">
								<?=$item['NAME']?>
							</a>
							<span class="wish" data-product-id="<?=$item['ID']?>"></span>
						</p>
						<p class="catalog_item__price"><?=intval($item['CATALOG_PRICE_1'])?>&nbsp;₽</p>
					</div>
				</div>
			<?}?>
		</div>
	</section>
	<? endif; ?>
</div>