<?php

namespace Silab\SiteCore\Repositories;

/**
 * WishlistRepository - класс для получения избранных товаров
 */
final class WishlistRepository
{
    /**
     * Получение избранных товаров
     * 
     * @return array
     */
    public function getList(): array
    {
        if (!\Bitrix\Main\Loader::includeModule('catalog')) die();

        global $USER;

        if (!$USER->IsAuthorized()) {
            if ($wishlistIds = unserialize($_COOKIE["BX_WISHLIST_IDS"])) {
                foreach ($wishlistIds as $key => $value) {
                    if (!is_numeric($key) || !is_numeric($value)) {
                        $wishlistIds = [];
                        break;
                    }
                }
            } else {
                $wishlistIds = [];
            }
        } else {
            $userId = $USER->GetID();
            $userObject = \CUser::GetByID($userId);
            $userArray = $userObject->Fetch();
            $wishlistIds = $userArray['UF_WISHLIST'];
        }

        return $wishlistIds;
    }
}
