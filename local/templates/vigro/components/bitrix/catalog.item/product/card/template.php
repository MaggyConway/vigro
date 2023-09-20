<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var string $discountPositionClass
 * @var string $labelPositionClass
 * @var CatalogSectionComponent $component
 */



$array_words = array();
$separator = " ";
$tok = strtok($productTitle, $separator);
while ($tok) {
	$array_words[] = $tok;
	$tok = strtok(" ");
}

$productColor = end($array_words);

$productTitle = $array_words[0];

$category = array_slice($array_words, 1, 3);
$category = implode(" ", $category);


$cdnImagesList = $item['PROPERTIES']['CDN_IMAGES_LIST']['VALUE'];
$articul = $item['PROPERTIES']['SANINVEST_ARTICUL']['VALUE'];

if (\Bitrix\Main\Loader::includeModule('silab.sitecore')) {
	$images = \Silab\SiteCore\Repositories\ProductRepository::ConvertImagePath($cdnImagesList, $articul);
}

$image = array_shift($images);

if(empty($cdnImagesList)) {
	$image = SITE_TEMPLATE_PATH.'/assets/images/no-image.png';
}

$productRepository = new Silab\SiteCore\Repositories\ProductRepository();

$arr_price = $productRepository->getPrice($item['ID']);
$price = number_format(intval($arr_price[0]["PRICE"]), 2, ',', ' ');

// echo "<pre>";
// var_dump($item['PROPERTIES']['OFFERS']['VALUE']);
// echo "</pre>";
?>

<div class="catalog_item">
	<? if (!empty($item['PROPERTIES']['OFFERS']['VALUE'])) { ?>
		<span class="item--sticker"><?= $item['PROPERTIES']['OFFERS']['VALUE'] ?></span>
	<? } ?>

	<a href="<?= $item['DETAIL_PAGE_URL'] ?>">
		<img
			src="<?= $image ?>"
			alt="<?= $articul ?>"
		/>
	</a>
	<p class="catalog_item__title">
		<a href="<?= $item['DETAIL_PAGE_URL'] ?>">
			<?= $productTitle ?>
		</a>
		<?
		$object = new Silab\SiteCore\Repositories\WishlistRepository;
		$wishlist = $object->getList();
		in_array($item['ID'], $wishlist) ? $state = 'active' : $state = '';
		?>
		<span class="wish <?=$state?>" data-product-id="<?=$item['ID']?>"></span>
	</p>
	<p class="catalog_item__price"><?=$price?> ₽</p>
</div>