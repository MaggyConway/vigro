<?php

namespace Silab\SiteCore\Services;

use Silab\SiteCore\Interfaces\ExportFileInterface;

/**
 * csv - класс для герерации данных из товаров в csv-формате
 */
class ExportCsvService implements ExportFileInterface
{
    /**
     * Генерация заголовков ответа
     * 
     * @return void
     */
    private function headers()
    {
        $fileName = 'wishlist.csv';
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {" . gmdate("D, d M Y H:i:s") . "} GMT");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Content-Transfer-Encoding: binary");
    }

    /**
     * Генерация данных из товаров в csv-формате
     * 
     * @param array products Товары
     * @return string:bool
     */
    public function export(array $wishlistIds)
    {
        $this->headers();

        $titles = ['Артикул', 'Название', 'Цена'];
        
        foreach ($wishlistIds as $id) {
            $product = \CCatalogProduct::GetByIDEx($id);
            if ($product) {
                $products[$id]['article'] = $product['PROPERTIES']['SANINVEST_ARTICUL']['VALUE'];
                $products[$id]['name'] = $product['NAME'];
                $products[$id]['price'] = intval($product['PRICES'][1]['PRICE']) . ' ' . $product['PRICES'][1]['CURRENCY'];
            }
        }

        if (count($products) == 0) {
            return null;
        }

        $df = fopen("php://output", 'w');
        fputcsv($df, $titles, ';');
        foreach ($products as $row) {
            fputcsv($df, $row, ';');
        }
        fclose($df);
    }
}
