<?php
// подключение служебной части пролога
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$object = new Silab\SiteCore\Services\ExportDataService('ExportCsvService', 'WishlistRepository');
echo $object->getFile();
