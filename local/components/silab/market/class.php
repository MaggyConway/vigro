<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!\Bitrix\Main\Loader::includeModule('silab.sitecore'))
{
    die();
}     

use Silab\SiteCore\Services\MarketService;

class MarketComponent extends \CBitrixComponent
{   
    /**
     * выполняет логику работы компонента
     */
    public function executeComponent()
    {
        $market = new MarketService();
        
        $this->arResult['MARKET_OZON_LINK'] = $market->getLinkOzon($this->arParams['SANINVEST_ARTICUL']);
        $this->arResult['MARKET_YANDEX_LINK'] = $market->getLinkYandex($this->arParams['SANINVEST_ARTICUL']);
        
        $this->includeComponentTemplate();
    }
}?>