<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

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

$interior_photo = CFile::GetPath($item['PROPERTIES']['INTERIOR_PHOTO']['VALUE']);


$cdnImagesList = $item['PROPERTIES']['CDN_IMAGES_LIST']['VALUE'];
$articul = $item['PROPERTIES']['SANINVEST_ARTICUL']['VALUE'];

if (\Bitrix\Main\Loader::includeModule('silab.sitecore')) {
	$images = \Silab\SiteCore\Repositories\ProductRepository::ConvertImagePath($cdnImagesList, $articul);
}

$image = array_shift($images);

if(empty($cdnImagesList)) {
	$image = SITE_TEMPLATE_PATH.'/assets/images/no-image.png';
}

// echo "<pre>";
// var_dump($item['PROPERTIES']['OFFERS']['VALUE']);
// echo "</pre>";
?>

<div class="accessories__gallery__map" data-entity="item">
	<img src="<?= $image ?>" alt="image" />
	<div class="accessories__gallery__map__item" style="top: 10.11%; left: 62.37%;">
		<a href="<?= $item['DETAIL_PAGE_URL'] ?>" target="_blank" class="pin"></a>
		<div class="accessories__gallery__map__item--desc">
			<p><?= $productTitle ?>&nbsp;></p>
			<p><?= $category ?></p>
		</div>
	</div>
</div>