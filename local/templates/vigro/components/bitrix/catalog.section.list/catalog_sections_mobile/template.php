<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if (0 < $arResult["SECTIONS_COUNT"])
{
?>

<div id="mobile_menu_panel">
	<div class="row flex-nowrap justify-content-between">
		<div class="col">
			<?
				$APPLICATION->IncludeComponent(
					"silab:search",
					"",
					[]
				);
			?>
		</div>
		<div class="col header__wishlist p-0">
			<a href="/wishlist/"></a>
		</div>
	</div>

	<ul class="mobile_menu">
		<li>
			<a href="javascript:void(0);">Каталог<span></span></a>
			<ul class="submenu">
	<?
		$intCurrentDepth = 1;
		$boolFirst = true;
		foreach ($arResult['SECTIONS'] as &$arSection)
		{
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

			if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL'])
			{
				if (0 < $intCurrentDepth)
					echo "\n",str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']),'<ul>';
			}
			elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL'])
			{
				if (!$boolFirst)
					echo '</li>';
			}
			else
			{
				while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL'])
				{
					echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
					$intCurrentDepth--;
				}
				echo str_repeat("\t", $intCurrentDepth-1),'</li>';
			}

			echo (!$boolFirst ? "\n" : ''),str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
			?><li>
				<a href="<? echo $arSection["SECTION_PAGE_URL"]; ?>">

				<? //echo '<pre>'; var_dump($arSection['CODE']); echo '</pre>'; ?>
				
				<img
					src="<?=$arSection['PICTURE']['SRC']?>"
					alt="main_menu_icon"
				/>
				
				<? echo $arSection["NAME"];?></a><?
			$intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
			$boolFirst = false;
		}
		unset($arSection);
		while ($intCurrentDepth > 1)
		{
			echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul></div>',"\n",str_repeat("\t", $intCurrentDepth-1);
			$intCurrentDepth--;
		}
		if ($intCurrentDepth > 0)
		{
			echo '</li>',"\n";
		}
	?>
	</ul></li>
		<li><a href="/ideas/">Идеи для&nbsp;кухни</a></li>
		<li><a href="/blog/">Блог</a></li>
		<li><a href="/partners/">Партнерам</a></li>
		<li><a href="/services/">Сервисные центры</a></li>
		<li><a href="/about/">О&nbsp;компании</a></li>
		<li><a href="/contacts/">Контакты</a></li>
	</ul>
</div>

<?}?>