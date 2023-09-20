<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (empty($arResult))
    return;
?>

<ul class="col-md-8 row gx-md-5 gx-lg-4 gx-xl-5 main_menu d-none d-md-flex flex-nowrap">
    <?php foreach ($arResult as $key => $item): ?>
        <li class="<?= $key !== 0 ? 'header_menu_from_serch' : '' ?> col-auto <?= $item["SELECTED"] ? 'active' : '' ?>">
            <a href="<?= $item['LINK'] ? $item['LINK'] : 'javascript:void(0);' ?>" id="<?= $key == 0 ? 'main_menu_trigger' : '' ?>"><?=$item['TEXT']?></a>
        </li>
    <?php endforeach; ?>
</ul>
