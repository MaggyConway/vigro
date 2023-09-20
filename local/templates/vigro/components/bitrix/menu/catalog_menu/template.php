<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)) : ?>

	<ul>

		<?
		$previousLevel = 0;

		foreach ($arResult as $arItem) :
			$array_words = [];
			$tok = strtok($arItem["LINK"], "/");
			while ($tok) {
				$array_words[] = $tok;
				$tok = strtok("/");
			}
			$arItem['linka'] = $array_words[3];

		?>
			<? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) : ?>
				<?= str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
			<? endif ?>

			<? if ($arItem["IS_PARENT"]) :
				//echo 'is parent'; 
			?>

				<? if ($arItem["DEPTH_LEVEL"] == 1) : ?>
					<li><a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
						<ul class="submenu">
						<? else : ?>
							<li><a href="<?= $arItem["LINK"] ?>" class="parent"><?= $arItem["TEXT"] ?></a>

								<ul class="subcontent">
								<? endif ?>

							<? else :
							// echo 'is not parent!'; 
							?>

								<? if ($arItem["PERMISSION"] > "D") :
									if ($arItem["DEPTH_LEVEL"] == 3) {
										$rsSections = CIBlockSection::GetList(array(), array('IBLOCK_ID' => 19, '=CODE' => $arItem['linka']));
										if ($arSection = $rsSections->Fetch()) {
											$img = CFile::GetPath($arSection["PICTURE"]);
										} ?>

										<li>
											<a class="main_menu-section" href="<?= $arItem["LINK"] ?>" data-section-id="<?= $arSection['ID'] ?>">
												<?= '<img src="' . $img . '" alt="' . $arSection['NAME'] . '" />' ?>
												<span><?= $arItem["TEXT"] ?></span>
											</a>
										</li>
									<?
									} elseif ($arItem["DEPTH_LEVEL"] == 2) {
										$rsSections = CIBlockSection::GetList(array(), array('IBLOCK_ID' => 19, '=CODE' => $arItem['linka']));
										if ($arSection = $rsSections->Fetch()) {
											$img = CFile::GetPath($arSection["PICTURE"]);
										} 

										$res_elems = [];
										$arSelect = array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PROPERTY_STICKER", "PROPERTY_CDN_IMAGES_LIST", "PROPERTY_SANINVEST_ARTICUL");
										$arFilter = array("IBLOCK_TYPE" => "shop", "IBLOCK_ID" => 19, 'SECTION_CODE' => $array_words[2]);
										$res = CIBlockElement::GetList(array(), $arFilter, false, array("nTopCount" => 3), $arSelect);
										while ($ob = $res->GetNextElement()) {
											$res_elems[] = $ob->GetFields();
										}
										?>
										<li>
										<?if (!empty($res_elems)):?>
											<a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
											<div class="pop_section subpopular">
												<p>Популярные товары</p>
												<ul class="pop_section__items">

													<? 
													foreach ($res_elems as $key => $el) :
														
														$img = array_shift(Silab\SiteCore\Repositories\ProductRepository::ConvertImagePath(
															$el['PROPERTY_CDN_IMAGES_LIST_VALUE'],
															$el['PROPERTY_SANINVEST_ARTICUL_VALUE']
														));
													?>
														<li>
															<a href="<?= $el['DETAIL_PAGE_URL'] ?>">
																<? if ($el['PROPERTY_STICKER_VALUE'] !== NULL) :?>
																	<span class="item--sticker"><?= $el['PROPERTY_STICKER_VALUE'] ?></span>
																<? endif ?>

																<?if (!is_null($img)):?>
																	<img src="<?=$img?>" alt="<?=$el['NAME']?>" />
																<?endif;?>

																<div class="card_title_block">
																	<p class="item--name"><?= $el['NAME'] ?></p>
																	<p class="item--category">Смеситель для&nbsp;раковины</p>
																</div>
															</a>
														</li>
													<? endforeach; ?>
												</ul>
												<a href="/catalog/<?=$array_words[1]?>/<?=$array_words[2]?>/" class="show_all">Смотреть все</a>
											</div>
										<?else:?>
											<a class="main_menu-soon" href="javascript:void(0)"><?= $arItem["TEXT"] ?></a>
										<?endif;?>
											
										</li>
									<? } else { ?>
										<li>
											<a href="<?= $arItem["LINK"] ?>" data-section-id="<?= $arSection['ID'] ?>">
												<?= $arItem["TEXT"] ?>
											</a>
										</li>
								<? }

								endif ?>

							<? endif ?>

							<? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

						<? endforeach ?>

						<? if ($previousLevel > 1) : //close last item tags 
						?>
							<?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
						<? endif ?>

								</ul>
							<? endif ?>