<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$id = filter_var($_POST["id"], FILTER_VALIDATE_INT) ?: die();

global $USER;

$object = new Silab\SiteCore\Repositories\WishlistRepository;
$wishlist = $object->getList();

$added = "false";

if (!$USER->IsAuthorized()) {
    if (!in_array($id, $wishlist)) {
        $wishlist[] = $id;
        $added = "true";
    } else {
        $key = array_search($id, $wishlist);
        unset($wishlist[$key]);
    }

    if (empty($wishlist)) {
        setcookie("BX_WISHLIST_IDS", '', time() - 1, "/", $_SERVER['SERVER_NAME'], false);
    } else {
        setcookie("BX_WISHLIST_IDS", serialize($wishlist), time() + 60 * 60 * 24 * 30, "/", $_SERVER['SERVER_NAME'], false);
    }
} else {
    $idUser = $USER->GetID();

    if (!in_array($id, $wishlist)) {
        $wishlist[] = $id;
        $added = "true";
    } else {
        $key = array_search($id, $wishlist);
        unset($wishlist[$key]);
    }

    $USER->Update($idUser, array("UF_WISHLIST" => $wishlist));
}

echo $added;
