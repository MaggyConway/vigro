<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

if (CModule::IncludeModule('iblock')):
    $counter = '';
    if ($_POST) {
        $props = $_POST['props'];
        $styles = $props[0];
        $colors = $props[1];

        $ideas = [];

        $res = CIBlockElement::GetList(
            Array("SORT"=>"ASC"), 
            Array("IBLOCK_ID" => $_ENV['IDEAS_ID'], "ACTIVE"=>"Y", "TAGS" => $styles, "PROPERTY_COLORS" => $colors), 
            false, false, 
            Array("ID", "NAME", "CODE", "TAGS", "PROPERTY_COLORS", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"));

        while ($el = $res->Fetch()) {
            $el['PREVIEW_PICTURE'] = CFile::GetPath($el['PREVIEW_PICTURE']);
            $ideas[] = $el;
        }


        
        if (count($ideas) == 1) {
            $counter = 'Результат: '.count($ideas).' идея';
        } elseif (count($ideas) == 2 || count($ideas) == 3 || count($ideas) == 4) {
            $counter = 'Результат: '.count($ideas).' идеи';
        } elseif (count($ideas) > 4) {
            $counter = 'Результат: '.count($ideas).' идей';
        } else {
            $counter = 'Пока ничего не нашлось..';
        }


        // echo '<pre>';
        // var_dump($ideas);
        // echo '</pre>';
    }
?>
    <h3><?=$counter?></h3>

    <ul class="step--result__grid">
        <? foreach ($ideas as $item) {?>
            <li>
                <a href="/ideas/<?=$item['CODE']?>/">
                    <img src="<?=$item['PREVIEW_PICTURE']?>" alt="<?=$item['NAME']?>" />
                    <p><?=$item['NAME']?></p>
                </a>
            </li>
        <?}?>
    </ul>
<? endif; ?>