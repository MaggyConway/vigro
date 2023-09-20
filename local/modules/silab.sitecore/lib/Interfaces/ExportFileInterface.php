<?php

namespace Silab\SiteCore\Interfaces;

/**
 * ExportFileInterface - интерфейс для генерации данных из товаров
 */
interface ExportFileInterface
{
    public function export(array $products);
}
