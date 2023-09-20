<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>


<main class="container page_blog">
	<section class="hero p-0">
		<img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="idea_hero_image" />

		<div class="hero--inner">
			<a href="/blog/" class="btn btn_back"
				>К&nbsp;списку статей</a
			>
			<h1><?=$arResult['NAME']?></h1>
		</div>
	</section>

	<?//echo '<pre>'; var_dump($arResult); echo '</pre>';?>

	<?=$arResult['DETAIL_TEXT']?>