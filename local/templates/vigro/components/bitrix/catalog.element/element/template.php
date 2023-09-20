<!-- КАРТОЧКА ТОВАРА, ВЕРСТКА -->

<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */


$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
	'STICKER_ID' => $mainId . '_sticker',
	'BIG_SLIDER_ID' => $mainId . '_big_slider',
	'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId . '_slider_cont',
	'OLD_PRICE_ID' => $mainId . '_old_price',
	'PRICE_ID' => $mainId . '_price',
	'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
	'PRICE_TOTAL' => $mainId . '_price_total',
	'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
	'QUANTITY_ID' => $mainId . '_quantity',
	'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
	'QUANTITY_UP_ID' => $mainId . '_quant_up',
	'QUANTITY_MEASURE' => $mainId . '_quant_measure',
	'QUANTITY_LIMIT' => $mainId . '_quant_limit',
	'BUY_LINK' => $mainId . '_buy_link',
	'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
	'COMPARE_LINK' => $mainId . '_compare_link',
	'TREE_ID' => $mainId . '_skudiv',
	'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
	'OFFER_GROUP' => $mainId . '_set_group_',
	'BASKET_PROP_DIV' => $mainId . '_basket_prop',
	'SUBSCRIBE_LINK' => $mainId . '_subscribe',
	'TABS_ID' => $mainId . '_tabs',
	'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
	'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers) {
	$actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
		? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
		: reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer) {
		if ($offer['MORE_PHOTO_COUNT'] > 1) {
			$showSliderControls = true;
			break;
		}
	}
} else {
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
	}
}

global $USER;


$cdnImagesList = $arResult['PROPERTIES']['CDN_IMAGES_LIST']['VALUE'];
$articul = $arResult['PROPERTIES']['SANINVEST_ARTICUL']['VALUE'];

if (\Bitrix\Main\Loader::includeModule('silab.sitecore')) {
	$images = \Silab\SiteCore\Repositories\ProductRepository::ConvertImagePath($cdnImagesList, $articul);
}

// if(empty($cdnImagesList)) {
	// $image = SITE_TEMPLATE_PATH.'/assets/images/no-image.png';
// }

// $image = array_shift($images);

// echo "<pre>";
// var_dump($images);
// echo "</pre>";
?>



<main class="container catalog_element" id="<?= $itemIds['ID'] ?>">
	<section>

		<? $APPLICATION->IncludeComponent(
			"bitrix:breadcrumb",
			"breadcrumbs",
			Array(
				"START_FROM" => "0",
				"PATH" => "",
				"SITE_ID" => "s2"
			)
		); ?>

		<div class="row gx-6 flex-column flex-md-row">
			<!-- <div class="col-12 col-md-6 catalog_element__slider"> -->





				<!-- <ul class="col-auto catalog_element__thumbnails">
					<li class="selected"><img src="/local/templates/vigro/assets/images/mini_el.png" alt="thumbnail" /></li>
					<li><img src="/local/templates/vigro/assets/images/mini_el.png" alt="thumbnail" /></li>
					<li><img src="/local/templates/vigro/assets/images/mini_el.png" alt="thumbnail" /></li>
				</ul>
				
				<div class="col-auto catalog_element__image">
					<img src="/local/templates/vigro/assets/images/element.png" alt="detail_image" />
				</div> -->





		<div class="product-item-detail-slider-container col-12 col-md-6 catalog_element__slider" id="<?= $itemIds['BIG_SLIDER_ID'] ?>">
			<span class="product-item-detail-slider-close" data-entity="close-popup"></span>
			<div class="product-item-detail-slider-block
						<?= ($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '') ?>" data-entity="images-slider-block">
				<span class="product-item-detail-slider-left" data-entity="slider-control-left" style="display: none;"></span>
				<span class="product-item-detail-slider-right" data-entity="slider-control-right" style="display: none;"></span>
				<div class="product-item-label-text <?= $labelPositionClass ?>" id="<?= $itemIds['STICKER_ID'] ?>" <?= (!$arResult['LABEL'] ? 'style="display: none;"' : '') ?>>
					<?php
					if ($arResult['LABEL'] && !empty($arResult['LABEL_ARRAY_VALUE'])) {
						foreach ($arResult['LABEL_ARRAY_VALUE'] as $code => $value) {
					?>
							<div<?= (!isset($arParams['LABEL_PROP_MOBILE'][$code]) ? ' class="hidden-xs"' : '') ?>>
								<span title="<?= $value ?>"><?= $value ?></span>
				</div>
		<?php
						}
					}
		?>
			</div>
			<div class="product-item-detail-slider-images-container col-auto catalog_element__image" data-entity="images-container">
				<?php
				if (!empty($images)) {
					foreach ($images as $key => $photo) {
				?>
						<div class="product-item-detail-slider-image<?= ($key == 0 ? ' selected' : '') ?>" data-entity="image" data-id="<?= $key ?>">
							<img src="<?= $photo ?>" alt="<?= $alt ?>" title="<?= $title ?>" <?= ($key == 0 ? ' itemprop="image"' : '') ?>>
						</div>
					<?php
					}
				} else {?>
					<div class="product-item-detail-slider-image<?= ($key == 0 ? ' selected' : '') ?>" data-entity="image" data-id="<?= $key ?>">
						<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/no-image.png' ?>" alt="<?= $alt ?>" title="<?= $title ?>" <?= ($key == 0 ? ' itemprop="image"' : '') ?>>
					</div>
				<?}

				if ($arParams['SLIDER_PROGRESS'] === 'Y') {
					?>
					<div class="product-item-detail-slider-progress-bar" data-entity="slider-progress-bar" style="width: 0;"></div>
				<?php
				}
				?>
			</div>
		</div>
		<?php
		if ($showSliderControls) {
			if ($haveOffers) {
				foreach ($arResult['OFFERS'] as $keyOffer => $offer) {
					if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
						continue;

					$strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
		?>
					<ul class="product-item-detail-slider-controls-block col-auto catalog_element__thumbnails" id="<?= $itemIds['SLIDER_CONT_OF_ID'] . $offer['ID'] ?>" style="display: <?= $strVisible ?>;">
						<?php
						foreach ($images as $keyPhoto => $photo) {
						?>
						<li class="product-item-detail-slider-controls-image<?= ($keyPhoto == 0 ? ' active' : '') ?>" data-entity="slider-control" data-value="<?= $offer['ID'] . '_' . $keyPhoto ?>">
								<img src="<?= $photo ?>">
						</li>
						<?php
						}
						?>
					</ul>
				<?php
				}
			} else {
				?>
				<div class="product-item-detail-slider-controls-block" id="<?= $itemIds['SLIDER_CONT_ID'] ?>">
					<?php
					if (!empty($images)) {
						foreach ($images as $key => $photo) {
					?>
							<div class="product-item-detail-slider-controls-image<?= ($key == 0 ? ' active' : '') ?>" data-entity="slider-control" data-value="<?= $key ?>">
								<img src="<?= $photo ?>">123
							</div>
					<?php
						}
					}
					?>
				</div>
		<?php
			}
		}
		?>






			</div>
			<div class="col-12 col-md-6">
				<h1><?=$arResult['NAME']?></h1>



<div class="product_card_detail">

		<!-- <div class="reference"><span>Артикул:</span>&nbsp;<? //= $arResult["PROPERTIES"]["REFERENCE"]["VALUE"] 
																?></div> -->

		<!-- <div class="product-item-detail-pay-block"> -->
			<? foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName) {
				switch ($blockName) {

					case 'price': ?>

						<?
						$productRepository = new Silab\SiteCore\Repositories\ProductRepository();

						$arr_price = $productRepository->getPrice($arResult['ID']);
						$price = number_format(intval($arr_price[0]["PRICE"]), 2, ',', ' ');

						if (is_string($price) && strlen($price) > 0) : ?>
							<p class="catalog_element__price" id="<?= $itemIds['PRICE_ID'] ?>"><?= $price ?> ₽</p>
						<? endif; ?>
			<?
						break;
				}
			} ?>
		<!-- </div> -->

		<?php
		foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName) {
			switch ($blockName) {
				case 'sku':
					if ($haveOffers && !empty($arResult['OFFERS_PROP'])) { ?>
						<div id="<?= $itemIds['TREE_ID'] ?>">
							<?php
							foreach ($arResult['SKU_PROPS'] as $skuProperty) {
								if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
									continue;

								$propertyId = $skuProperty['ID'];
								$skuProps[] = array(
									'ID' => $propertyId,
									'SHOW_MODE' => $skuProperty['SHOW_MODE'],
									'VALUES' => $skuProperty['VALUES'],
									'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
								);
							?>
								<div class="product-item-detail-info-container" data-entity="sku-line-block">
									<div class="product-item-detail-info-container-title"><?= htmlspecialcharsEx($skuProperty['NAME']) ?></div>
									<div class="product-item-scu-container">
										<div class="product-item-scu-block">
											<div class="product-item-scu-list">
												<ul class="product-item-scu-item-list">
													<?php
													foreach ($skuProperty['VALUES'] as &$value) {
														$value['NAME'] = htmlspecialcharsbx($value['NAME']);

														if ($skuProperty['SHOW_MODE'] === 'PICT') {
													?>
															<li class="product-item-scu-item-color-container" title="<?= $value['NAME'] ?>" data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>" data-onevalue="<?= $value['ID'] ?>">
																<div class="product-item-scu-item-color-block">
																	<div class="product-item-scu-item-color" title="<?= $value['NAME'] ?>" style="background-image: url('<?= $value['PICT']['SRC'] ?>');">
																	</div>
																</div>
															</li>
														<?php
														} else {
														?>
															<li class="product-item-scu-item-text-container" title="<?= $value['NAME'] ?>" data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>" data-onevalue="<?= $value['ID'] ?>">
																<div class="product-item-scu-item-text-block">
																	<div class="product-item-scu-item-text"><?= $value['NAME'] ?></div>
																</div>
															</li>
													<?php
														}
													}
													?>
												</ul>
												<div style="clear: both;"></div>
											</div>
										</div>
									</div>
								</div>
							<?php
							}
							?>
						</div>
		<?php
					}
					break;
			}
		}
		?>

		<!-- <div class="detail_block">
			<p>Цвет:</p>

			<ul>
				<li><a href="#"><img src="/local/templates/maxonor/assets/images/color1.svg" alt="color" /></a></li>
				<li><a href="#"><img src="/local/templates/maxonor/assets/images/color2.svg" alt="color" /></a></li>
				<li><a href="#"><img src="/local/templates/maxonor/assets/images/color3.svg" alt="color" /></a></li>
			</ul>
		</div> -->

		<? 
			// $APPLICATION->IncludeComponent(
			// 	"silab:market",
			// 	"",
			// 	array(
			// 		'SANINVEST_ARTICUL' => $arResult['PROPERTIES']['SANINVEST_ARTICUL']['VALUE']
			// 	)
			// );
		?>
	</div>



				<!-- <p class="catalog_element__price">4&nbsp;592&nbsp;₽</p> -->
				<p class="catalog_element__current_color"><span>Цвет:</span><?=$arResult['PROPERTIES']['COLOR']['VALUE']?></p>

				<!-- <ul class="catalog_element__choice_color">
					<li><img src="/local/templates/vigro/assets/images/color1.svg" alt="color"></li>
					<li><img src="/local/templates/vigro/assets/images/color2.svg" alt="color"></li>
					<li><img src="/local/templates/vigro/assets/images/color3.svg" alt="color"></li>
					<li><img src="/local/templates/vigro/assets/images/color4.svg" alt="color"></li>
					<li><img src="/local/templates/vigro/assets/images/color5.svg" alt="color"></li>
					<li><img src="/local/templates/vigro/assets/images/color6.svg" alt="color"></li>

					<li><img src="/local/templates/vigro/assets/images/color1.svg" alt="color"></li>
					<li><img src="/local/templates/vigro/assets/images/color2.svg" alt="color"></li>
					<li><img src="/local/templates/vigro/assets/images/color3.svg" alt="color"></li>
					<li><img src="/local/templates/vigro/assets/images/color4.svg" alt="color"></li>
					<li><img src="/local/templates/vigro/assets/images/color5.svg" alt="color"></li>
					<li class="selected"><img src="/local/templates/vigro/assets/images/color6.svg" alt="color"></li>
				</ul> -->

				<p class="mb-3">Купить</p>
				
				<div class="catalog_element__btns">
					<?
						$APPLICATION->IncludeComponent(
							"silab:market",
							"",
							array(
								'SANINVEST_ARTICUL' => $arResult['PROPERTIES']['SANINVEST_ARTICUL']['VALUE']
							)
						);
					?>

					<!-- <a href="javascript:void(0);" class="btn btn_buy">Купить</a> -->
					<div>
						<span class="btn_wish <?=Silab\SiteCore\Services\WishlistStateService::getState($arResult['ID'])?>" style="width: 55px; height: 40px; background-size: contain;" data-product-id="<?=$arResult['ID']?>"></span>
					</div>
				</div>
				<??>
			</div>
		</div>
	</section>

	<? if ($showDescription) {?>
	<section class="catalog_element__description">
		<h2>Описание</h2>
		<p>
			<!-- Удобная и&nbsp;практичная кухонная мойка VIGRO изготовлена из&nbsp;искусственного мрамора. Благодаря сочетанию мраморной крошки и&nbsp;акриловых смол материал прочнее натурального камня почти в&nbsp;8 раз. Акриловая смола после обработки абсолютно безопасна для здоровья: эмиссия вредных веществ составляет 0%. Двухконтурная поверхность чаши с&nbsp;шероховатым дном и&nbsp;гладкими стенками обеспечивает дополнительную прочность и&nbsp;противоскользящий эффект, максимально снижая появление брызг при сильном напоре воды. <nobr>Декоративно-защитное</nobr> покрытие гелькоут обладает антибактериальным эффектом, благодаря чему на&nbsp;поверхности не&nbsp;скапливается грязь и&nbsp;не&nbsp;размножаются бактерии. Мойка без труда чистится и&nbsp;долго служит, сохраняя свой цвет и&nbsp;первозданный внешний вид. -->

			<?=$arResult['PREVIEW_TEXT']?>
		</p>
	</section>
	<?}?>

	<!-- <section class="catalog_element__props">
		<h2>Характеристики</h2>
		<ul>
			<li><span>Тип</span><span>Мойка</span></li>
			<li><span>Установка</span><span>Врезная</span></li>
			<li><span>Минимальный размер тумбы</span><span>45см</span></li>
			<li><span>Материал</span><span>Искусственный мрамор</span></li>
			<li><span>Число основных чаш</span><span>1</span></li>
			<li><span>Форма мойки</span><span>Круг</span></li>
			<li><span>Страна-изготовитель</span><span>Россия</span></li>
			<li><span>Цвет</span><span>Обсидиан</span></li>
			<li><span>Ширина, см</span><span>50.5</span></li>

			<li><span>Высота, см</span><span>21</span></li>
			<li><span>Диаметр слива, мм</span><span>90</span></li>
			<li><span>Бренд</span><span>VIGRO</span></li>
			<li><span>Отверстия под смеситель</span><span>1</span></li>
			<li><span>Глубина, см</span><span>21</span></li>
			<li><span>Гарантия</span><span>2 года</span></li>
			<li><span>Покрытие</span><span>Антибактериальное</span></li>
			<li><span>Клапан-автомат</span><span>Нет</span></li>
		</ul>
	</section> -->



	<?
// echo '<pre>';
// var_dump($arResult["PROPERTIES"]);
// echo '</pre>';

if (!empty($arResult['PROPERTIES'])) { ?>
	<section class="catalog_element__props">
		<h2>Характеристики:</h2>
		<ul>
			<?php
			foreach ($arResult['PROPERTIES'] as $property) {
				
				if(!empty($property['VALUE']) && $property['NAME'] != 'CDN_IMAGES_LIST') {?>
					<li><span><?= $property['NAME'] ?>:</span>
					<span>
						<?= (is_array($property['VALUE'])
							? implode(' / ', $property['VALUE'])
							: $property['VALUE']) ?>
					</span></li>
				<?}
				?>
			<? }
			unset($property); ?>
		</ul>
	</section>
<? } ?>

	
	<!-- <section class="catalog_element__anothers">
		<h2>Для&nbsp;этой мойки подойдут смесители</h2>

		<div class="row g-6">
			<div class="p-0 col-9 col-sm-5 col-lg-3 catalog_item hit">
				<a href="javascript:void(0);">
					<img
						src="/local/templates/vigro/assets/images/faucet1.svg"
						alt="catalog_item_image"
					/>
				</a>
				<p class="catalog_item__title">
					<a href="javascript:void(0);">
						Vigro VG502
					</a>
					<span class="wish"></span>
				</p>
				<p class="catalog_item__price">8&nbsp;833&nbsp;₽</p>
			</div>
	
			<div class="p-0 col-9 col-sm-5 col-lg-3 catalog_item new">
				<a href="javascript:void(0);">
					<img
						src="/local/templates/vigro/assets/images/faucet2.svg"
						alt="catalog_item_image"
					/>
				</a>
				<p class="catalog_item__title">
					<a href="javascript:void(0);">
						Vigro VG502
					</a>
					<span class="wish active"></span>
				</p>
				<p class="catalog_item__price">8&nbsp;833&nbsp;₽</p>
			</div>
	
			<div class="p-0 col-9 col-sm-5 col-lg-3 catalog_item">
				<a href="javascript:void(0);">
					<img
						src="/local/templates/vigro/assets/images/faucet3.svg"
						alt="catalog_item_image"
					/>
				</a>
				<p class="catalog_item__title">
					<a href="javascript:void(0);">
						Vigro VG502
					</a>
					<span class="wish active"></span>
				</p>
				<p class="catalog_item__price">8&nbsp;833&nbsp;₽</p>
			</div>
		</div>

	</section>

	<section>
		<h2>Комплектация приобретается отдельно</h2>

		<div class="row g-0">
			<div class="p-0 col-9 col-sm-5 col-lg-3 catalog_item">
				<a href="javascript:void(0);">
					<img
						src="/local/templates/vigro/assets/images/catalog_item1.png"
						alt="catalog_item_image"
						style="visibility: hidden;"
					/>
				</a>
				<p class="catalog_item__title">
					<a href="javascript:void(0);">
						Сифон
					</a>
					<span class="wish"></span>
				</p>
				<p class="catalog_item__price">-&nbsp;₽</p>
			</div>
	
			<div class="p-0 col-9 col-sm-5 col-lg-3 catalog_item">
				<a href="javascript:void(0);">
					<img
						src="/local/templates/vigro/assets/images/catalog_item2.png"
						alt="catalog_item_image"
						style="visibility: hidden;"
					/>
				</a>
				<p class="catalog_item__title">
					<a href="javascript:void(0);">
						Силикон
					</a>
					<span class="wish active"></span>
				</p>
				<p class="catalog_item__price">-&nbsp;₽</p>
			</div>
	</section> -->

	<!-- <section class="catalog_element__video">
		<h2>Видео покупателей</h2>

		<div class="row g-6">
			<div class="col-12 col-md-6 col-xl-3">
				<img src="/local/templates/vigro/assets/images/video1.png" alt="preview" />
				<button class="play"></button>
			</div>
			<div class="col-12 col-md-6 col-xl-3">
				<img src="/local/templates/vigro/assets/images/video2.png" alt="preview" />
				<button class="play"></button>
			</div>
			<div class="col-12 col-md-6 col-xl-3">
				<img src="/local/templates/vigro/assets/images/video3.png" alt="preview" />
				<button class="play"></button>
			</div>
		</div>
	</section> -->

<?
$bowl_adv_iblock_id = $arResult['PROPERTIES']['BOWL_ADV']['LINK_IBLOCK_ID'];
$current_bowl = $arResult['PROPERTIES']['BOWL_ADV']['VALUE'];

if (intval($current_bowl) > 0):

	$bowl_fields = NULL;
	$bowl_props = NULL;
	
	$arFilter = Array("IBLOCK_ID"=>$bowl_adv_iblock_id, "ID"=>$current_bowl);
	$res = CIBlockElement::GetList(Array(), $arFilter);
	if ($ob = $res->GetNextElement()){;
		$bowl_fields = $ob->GetFields();
		$bowl_props = $ob->GetProperties();
	}
?>
	<section class="catalog_element__advantages">
		<div class="row gx-md-6 gy-6 gy-md-7 flex-wrap">
			<div class="col-12 col-md-5 col-xl-3">
				<h2><?=$bowl_fields['NAME']?></h2>
				<p>
					<?=$bowl_props['TEXT_LEFT']['~VALUE']['TEXT']?>
				</p>
			</div>
			<div class="col-12 col-md-7 col-xl-9">
				<img src="<?=CFile::GetPath($bowl_props['IMAGE_RIGHT']['VALUE']);?>" alt="<?=$bowl_fields['NAME']?>" />
			</div>


			<div class="col-12 col-md-7 col-xl-9">
				<img src="<?=CFile::GetPath($bowl_props['IMAGE_LEFT']['VALUE']);?>" alt="<?=$bowl_fields['NAME']?>" />
			</div>
			<div class="col-12 col-md-5 col-xl-3">
				<p>
					<?=$bowl_props['TEXT_RIGHT']['~VALUE']['TEXT']?>
				</p>
			</div>
		</div>
	</section>
<?endif;?>

	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"articles",
		Array(
			'CUSTOM_TITLE' => "Читайте ещё",
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"AJAX_MODE" => "Y",
			"IBLOCK_TYPE" => "content_vigro",
			"IBLOCK_ID" => $_ENV['BLOG_ID'],
			"NEWS_COUNT" => "10",
			"SORT_BY1" => "ACTIVE_FROM",
			"SORT_ORDER1" => "DESC",
			"SORT_BY2" => "SORT",
			"SORT_ORDER2" => "ASC",
			"FILTER_NAME" => "",
			"FIELD_CODE" => Array("ID"),
			"PROPERTY_CODE" => Array(),
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"PREVIEW_TRUNCATE_LEN" => "",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"SET_TITLE" => "N",
			"SET_BROWSER_TITLE" => "N",
			"SET_META_KEYWORDS" => "N",
			"SET_META_DESCRIPTION" => "N",
			"SET_LAST_MODIFIED" => "Y",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"INCLUDE_SUBSECTIONS" => "Y",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => "Y",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"PAGER_TITLE" => "Преимущества",
			"PAGER_SHOW_ALWAYS" => "Y",
			"PAGER_TEMPLATE" => "",
			"PAGER_DESC_NUMBERING" => "Y",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_BASE_LINK_ENABLE" => "Y",
			"SET_STATUS_404" => "N",
			"SHOW_404" => "N",
			"MESSAGE_404" => "",
			"PAGER_BASE_LINK" => "",
			"PAGER_PARAMS_NAME" => "arrPager",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_ADDITIONAL" => ""
		)
	);?>

	<!-- <section class="container news">
		<h2>Полезные статьи</h2>

		<div class="news__slider">
			<a href="javascript:void(0);">
				<img src="/local/templates/vigro/assets/images/news_image.jpg" alt="news_image" />
				<p>Как&nbsp;выбрать мойку?</p>
			</a>
			<a href="javascript:void(0);">
				<img src="/local/templates/vigro/assets/images/news_image.jpg" alt="news_image" />
				<p>Как&nbsp;выбрать мойку?</p>
			</a>
			<a href="javascript:void(0);">
				<img src="/local/templates/vigro/assets/images/news_image.jpg" alt="news_image" />
				<p>Как&nbsp;выбрать мойку?</p>
			</a>
			<a href="javascript:void(0);">
				<img src="/local/templates/vigro/assets/images/news_image.jpg" alt="news_image" />
				<p>Как&nbsp;выбрать мойку?</p>
			</a>
			<a href="javascript:void(0);">
				<img src="/local/templates/vigro/assets/images/news_image.jpg" alt="news_image" />
				<p>Как&nbsp;выбрать мойку?</p>
			</a>
		</div>

		<a href="/blog/" class="btn">Смотреть все</a>
	</section> -->
</main>





<main class="container catalog_element" id="<?= $itemIds['ID'] ?>">

<?/*	<div class="product_card_flex">

		<div class="product-item-detail-slider-container" id="<?= $itemIds['BIG_SLIDER_ID'] ?>">
			<span class="product-item-detail-slider-close" data-entity="close-popup"></span>
			<div class="product-item-detail-slider-block
						<?= ($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '') ?>" data-entity="images-slider-block">
				<span class="product-item-detail-slider-left" data-entity="slider-control-left" style="display: none;"></span>
				<span class="product-item-detail-slider-right" data-entity="slider-control-right" style="display: none;"></span>
				<div class="product-item-label-text <?= $labelPositionClass ?>" id="<?= $itemIds['STICKER_ID'] ?>" <?= (!$arResult['LABEL'] ? 'style="display: none;"' : '') ?>>
					<?php
					if ($arResult['LABEL'] && !empty($arResult['LABEL_ARRAY_VALUE'])) {
						foreach ($arResult['LABEL_ARRAY_VALUE'] as $code => $value) {
					?>
							<div<?= (!isset($arParams['LABEL_PROP_MOBILE'][$code]) ? ' class="hidden-xs"' : '') ?>>
								<span title="<?= $value ?>"><?= $value ?></span>
				</div>
		<?php
						}
					}
		?>
			</div>
			<div class="product-item-detail-slider-images-container" data-entity="images-container">
				<?php
				if (!empty($images)) {
					foreach ($images as $key => $photo) {
				?>
						<div class="product-item-detail-slider-image<?= ($key == 0 ? ' active' : '') ?>" data-entity="image" data-id="<?= $key ?>">
							<img src="<?= $photo ?>" alt="<?= $alt ?>" title="<?= $title ?>" <?= ($key == 0 ? ' itemprop="image"' : '') ?>>
						</div>
					<?php
					}
				}

				if ($arParams['SLIDER_PROGRESS'] === 'Y') {
					?>
					<div class="product-item-detail-slider-progress-bar" data-entity="slider-progress-bar" style="width: 0;"></div>
				<?php
				}
				?>
			</div>
		</div>
		<?php
		if ($showSliderControls) {
			if ($haveOffers) {
				foreach ($arResult['OFFERS'] as $keyOffer => $offer) {
					if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
						continue;

					$strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
		?>
					<div class="product-item-detail-slider-controls-block" id="<?= $itemIds['SLIDER_CONT_OF_ID'] . $offer['ID'] ?>" style="display: <?= $strVisible ?>;">
						<?php
						foreach ($images as $keyPhoto => $photo) {
						?>
							<div class="product-item-detail-slider-controls-image<?= ($keyPhoto == 0 ? ' active' : '') ?>" data-entity="slider-control" data-value="<?= $offer['ID'] . '_' . $keyPhoto ?>">
								<img src="<?= $photo ?>">
							</div>
						<?php
						}
						?>
					</div>
				<?php
				}
			} else {
				?>
				<div class="product-item-detail-slider-controls-block" id="<?= $itemIds['SLIDER_CONT_ID'] ?>">
					<?php
					if (!empty($images)) {
						foreach ($images as $key => $photo) {
					?>
							<div class="product-item-detail-slider-controls-image<?= ($key == 0 ? ' active' : '') ?>" data-entity="slider-control" data-value="<?= $key ?>">
								<img src="<?= $photo ?>">
							</div>
					<?php
						}
					}
					?>
				</div>
		<?php
			}
		}
		*/?>
	<!-- </div> -->

</div><!--  end of .producs_card_flex -->


<? 
// global $arrFilterElementDetailAccessories;

// $arrFilterElementDetailAccessories = [
// 	'=IBLOCK_SECTION_ID' => [
// 		'151', // Аксессуары для ванной
// 		'157', //Аксессуары для туалета
// 	]
// ];

// $current_collection_id = $arResult['PROPERTIES']['COLLECTION_ELEMENT_ID']["VALUE"];

// echo "<pre>";
// var_dump($arResult["DISPLAY_PROPERTIES"]["COLLECTION"]["LINK_ELEMENT_VALUE"][$current_collection_id]["NAME"]);
// echo "</pre>";
?>
</main><!-- end of product_card -->


<meta itemprop="name" content="<?= $name ?>" />
<meta itemprop="category" content="<?= $arResult['CATEGORY_PATH'] ?>" />

<? if ($haveOffers) {

	$offerIds = array();
	$offerCodes = array();

	$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

	foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer) {

		$offerIds[] = (int)$jsOffer['ID'];
		$offerCodes[] = $jsOffer['CODE'];

		$fullOffer = $arResult['OFFERS'][$ind];
		$measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

		$strAllProps = '';
		$strMainProps = '';
		$strPriceRangesRatio = '';
		$strPriceRanges = '';

		if ($arResult['SHOW_OFFERS_PROPS']) {

			if (!empty($jsOffer['DISPLAY_PROPERTIES'])) {

				foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property) {

					$current = '<dt>' . $property['NAME'] . '</dt><dd>' . (is_array($property['VALUE'])
						? implode(' / ', $property['VALUE'])
						: $property['VALUE']
					) . '</dd>';
					$strAllProps .= $current;

					if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']])) {
						$strMainProps .= $current;
					}
				}

				unset($current);
			}
		}

		if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1) {

			$strPriceRangesRatio = '(' . Loc::getMessage(
				'CT_BCE_CATALOG_RATIO_PRICE',
				array('#RATIO#' => ($useRatio
					? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
					: '1'
				) . ' ' . $measureName)
			) . ')';

			foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range) {
				if ($range['HASH'] !== 'ZERO-INF') {
					$itemPrice = false;

					foreach ($jsOffer['ITEM_PRICES'] as $itemPrice) {
						if ($itemPrice['QUANTITY_HASH'] === $range['HASH']) {
							break;
						}
					}

					if ($itemPrice) {

						$strPriceRanges .= '<dt>' . Loc::getMessage(
							'CT_BCE_CATALOG_RANGE_FROM',
							array('#FROM#' => $range['SORT_FROM'] . ' ' . $measureName)
						) . ' ';

						if (is_infinite($range['SORT_TO'])) {
							$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
						} else {
							$strPriceRanges .= Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_TO',
								array('#TO#' => $range['SORT_TO'] . ' ' . $measureName)
							);
						}

						$strPriceRanges .= '</dt><dd>' . ($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']) . '</dd>';
					}
				}
			}
			unset($range, $itemPrice);
		}

		$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
		$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
		$jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
		$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
	}

	$templateData['OFFER_IDS'] = $offerIds;
	$templateData['OFFER_CODES'] = $offerCodes;
	unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
		'VISUAL' => $itemIds,
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'NAME' => $arResult['~NAME'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $skuProps
	);
} else {
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);

	if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties) { ?>

		<div id="<?= $itemIds['BASKET_PROP_DIV'] ?>" style="display: none;">

			<? if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {

				foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo) { ?>
					<input type="hidden" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]" value="<?= htmlspecialcharsbx($propInfo['ID']) ?>">

				<? unset($arResult['PRODUCT_PROPERTIES'][$propId]);
				}
			}

			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties) { ?>
				<table>
					<? foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo) { ?>
						<tr>
							<td><?= $arResult['PROPERTIES'][$propId]['NAME'] ?></td>
							<td>
								<? if (
									$arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
									&& $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
								) {
									foreach ($propInfo['VALUES'] as $valueId => $value) { ?>
										<label>
											<input type="radio" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]" value="<?= $valueId ?>" <?= ($valueId == $propInfo['SELECTED'] ? '"checked"' : '') ?>>
											<?= $value ?>
										</label>
										<br>

									<? }
								} else { ?>

									<select name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]">
										<?
										foreach ($propInfo['VALUES'] as $valueId => $value) { ?>
											<option value="<?= $valueId ?>" <?= ($valueId == $propInfo['SELECTED'] ? '"selected"' : '') ?>>
												<?= $value ?>
											</option>
										<? } ?>
									</select>
								<? } ?>
							</td>
						</tr>
					<? } ?>
				</table>
			<? } ?>
		</div>
<? }

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'VISUAL' => $itemIds,
		'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'PICT' => reset($arResult['MORE_PHOTO']),
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
			'ITEM_PRICES' => $arResult['ITEM_PRICES'],
			'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
			'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
			'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
			'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
			'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
			'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
			'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	unset($emptyProductProperties);
} ?>

<script>
	BX.message({
		ECONOMY_INFO_MESSAGE: '<?= GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2') ?>',
		TITLE_ERROR: '<?= GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
		TITLE_BASKET_PROPS: '<?= GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
		BASKET_UNKNOWN_ERROR: '<?= GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		BTN_SEND_PROPS: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS') ?>',
		BTN_MESSAGE_BASKET_REDIRECT: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
		BTN_MESSAGE_CLOSE: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP') ?>',
		TITLE_SUCCESSFUL: '<?= GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK') ?>',
		COMPARE_MESSAGE_OK: '<?= GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK') ?>',
		COMPARE_UNKNOWN_ERROR: '<?= GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
		COMPARE_TITLE: '<?= GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE') ?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
		PRODUCT_GIFT_LABEL: '<?= GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL') ?>',
		PRICE_TOTAL_PREFIX: '<?= GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX') ?>',
		RELATIVE_QUANTITY_MANY: '<?= CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY']) ?>',
		RELATIVE_QUANTITY_FEW: '<?= CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW']) ?>',
		SITE_ID: '<?= CUtil::JSEscape($component->getSiteId()) ?>'
	});

	var <?= $obName ?> = new JCCatalogElement(<?= CUtil::PhpToJSObject($jsParams, false, true) ?>);
</script>

<? unset($actualItem, $itemIds, $jsParams);
