<?php

namespace Silab\SiteCore\Services;

use Silab\SiteCore\Repositories\WishlistRepository;

/**
 * WishlistStateService - класс для генерации css-стиля для избранного товара
 */
class WishlistStateService
{
    /**
     * Генерация css-стиля для избранного товара
     * 
     * @return string
     */
    public static function getState($id)
    {
        $object = new WishlistRepository;
        $wishlist = $object->getList();
        in_array($id, $wishlist) ? $state = 'active' : $state = '';

        return $state;
    }
}
