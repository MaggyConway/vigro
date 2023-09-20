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

// echo '<pre>'; var_dump($array_words); echo '</pre>';
// echo '<pre>'; var_dump($arResult); echo '</pre>';
?>

<a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="product-item new-goods__slider__item">
	<span class="item--sticker"><?= $item['PROPERTIES']['STICKER']['VALUE'] ?></span>
	<img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="product_image" />
	<div class="item--name"><?= $productTitle ?></div>
	<?
	if (!empty($category)) {?>
		<div class="item--category"><?=$category?></div>
	<?}?>
</a>