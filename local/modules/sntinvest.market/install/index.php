<?
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
Loader::IncludeModule('highloadblock');
use Bitrix\Highloadblock as HL;

Class sntinvest_market extends CModule{

    public function __construct(){

        if(file_exists(__DIR__."/version.php")){
    
            $arModuleVersion = array();
    
            include_once(__DIR__."/version.php");
    
            $this->MODULE_ID 		   = str_replace("_", ".", get_class($this));
            $this->MODULE_VERSION 	   = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
            $this->MODULE_NAME 		   = "Интеграция с маркетплейсами";
            $this->MODULE_DESCRIPTION  = "Интеграция OZON(1.0.0)";
            $this->PARTNER_NAME 	   = "ООО САНИНВЕСТ";
            $this->PARTNER_URI  	   = "sntinvest.ru";
        }
    
        return false;
    }

    public function DoInstall(){

        global $APPLICATION;
    
        if(CheckVersion(ModuleManager::getVersion("main"), "14.00.00"))
        {
            ModuleManager::registerModule($this->MODULE_ID);

                $this->CreateOzonProductsTable();
                $this->CreateYandexProductsTable();
                $this->CreateWbProductsTable();

        $APPLICATION->IncludeAdminFile(
            "Установка модуля"." Интеграция с маркетплейсами",
            __DIR__."/step.php"
        );
    
        return false;
    } else {
            $APPLICATION->ThrowException(
                "Версия главного модуля ниже 14. Не поддерживается технология D7, необходимая модулю. Пожалуйста обновите систему."
            );
            return false;
        }
    }

    public function DoUninstall(){


        global $APPLICATION;

        \Bitrix\Main\Loader::includeModule('highloadblock');


        $this->DeleteOzonProductsTable();
        $this->DeleteYandexProductsTable();
        $this->DeleteWbProductsTable();

        ModuleManager::unRegisterModule($this->MODULE_ID);


        $APPLICATION->IncludeAdminFile(
            "Деинсталляция модуля ".$this->MODULE_NAME,
            __DIR__."/unstep.php"
        );


        return false;
    }

    protected function CreateOzonProductsTable() {

            $result = HL\HighloadBlockTable::add(array(
                'NAME' => 'OzonProducts',//должно начинаться с заглавной буквы и состоять только из латинских букв и цифр
                'TABLE_NAME' => 'ozon_products',//должно состоять только из строчных латинских букв, цифр и знака подчеркивания
            ));

            $id = $result->getId();
            \Bitrix\Main\Config\Option::set($this->MODULE_ID, 'HL_ID', $id);
            HL\HighloadBlockLangTable::add(array(
                'ID' => $id,
                'LID' => 'ru',
                'NAME' => "Продукты на OZON"
            ));

            $UFObject = 'HLBLOCK_' . $id;

            $arCartFields = array(
                'UF_PRODUCTS_ID' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_PRODUCTS_ID',
                    'USER_TYPE_ID' => 'integer',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => 'products-id'),
                    "LIST_COLUMN_LABEL" => array('ru' => 'products-id'),
                    "LIST_FILTER_LABEL" => array('ru' => 'products-id'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_OFFER_ID' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_OFFER_ID',
                    'USER_TYPE_ID' => 'integer',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "offer-id"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'offer-id'),
                    "LIST_FILTER_LABEL" => array('ru' => 'offer-id'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_SKU' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_SKU',
                    'USER_TYPE_ID' => 'integer',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "sku"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'sku'),
                    "LIST_FILTER_LABEL" => array('ru' => 'sku'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_STOCKS_PRESENT' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_STOCKS_PRESENT',
                    'USER_TYPE_ID' => 'integer',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "stocks-present"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'stocks-present'),
                    "LIST_FILTER_LABEL" => array('ru' => 'stocks-present'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
            );

            $arSavedFieldsRes = array();

            foreach ($arCartFields as $ufName => $arCartField) {
                $obUserField = new CUserTypeEntity;
                $ID = $obUserField->Add($arCartField);

                $arSavedFieldsRes[] = $ID;
            }

    }

    protected function CreateYandexProductsTable() {

            $result = HL\HighloadBlockTable::add(array(
                'NAME' => 'YandexProducts',//должно начинаться с заглавной буквы и состоять только из латинских букв и цифр
                'TABLE_NAME' => 'yandex_products',//должно состоять только из строчных латинских букв, цифр и знака подчеркивания
            ));

            $id = $result->getId();
            \Bitrix\Main\Config\Option::set($this->MODULE_ID, 'HL_ID', $id);
            HL\HighloadBlockLangTable::add(array(
                'ID' => $id,
                'LID' => 'ru',
                'NAME' => "Продукты на Yandex.Market"
            ));

            $UFObject = 'HLBLOCK_' . $id;

            $arCartFields = array(
                'UF_NAME' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_NAME',
                    'USER_TYPE_ID' => 'string',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => 'name'),
                    "LIST_COLUMN_LABEL" => array('ru' => 'name'),
                    "LIST_FILTER_LABEL" => array('ru' => 'name'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_SHOP_SKU' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_SHOP_SKU',
                    'USER_TYPE_ID' => 'integer',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "shop-sku"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'shop-sku'),
                    "LIST_FILTER_LABEL" => array('ru' => 'shop-sku'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_MARKET_SKU' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_MARKET_SKU',
                    'USER_TYPE_ID' => 'integer',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "market-sku"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'market-sku'),
                    "LIST_FILTER_LABEL" => array('ru' => 'market-sku'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_MODEL_ID' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_MODEL_ID',
                    'USER_TYPE_ID' => 'integer',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "model-id"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'model-id'),
                    "LIST_FILTER_LABEL" => array('ru' => 'model-id'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_CATEGORY_ID' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_CATEGORY_ID',
                    'USER_TYPE_ID' => 'integer',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "category-id"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'category-id'),
                    "LIST_FILTER_LABEL" => array('ru' => 'category-id'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_COUNT' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_COUNT',
                    'USER_TYPE_ID' => 'integer',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "count"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'count'),
                    "LIST_FILTER_LABEL" => array('ru' => 'count'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
            );

            $arSavedFieldsRes = array();

            foreach ($arCartFields as $ufName => $arCartField) {
                $obUserField = new CUserTypeEntity;
                $ID = $obUserField->Add($arCartField);

                $arSavedFieldsRes[] = $ID;
            }

    }
    
    protected function CreateWbProductsTable() {

            $result = HL\HighloadBlockTable::add(array(
                'NAME' => 'WbProducts',//должно начинаться с заглавной буквы и состоять только из латинских букв и цифр
                'TABLE_NAME' => 'wb_products',//должно состоять только из строчных латинских букв, цифр и знака подчеркивания
            ));

            $id = $result->getId();
            \Bitrix\Main\Config\Option::set($this->MODULE_ID, 'HL_ID', $id);
            HL\HighloadBlockLangTable::add(array(
                'ID' => $id,
                'LID' => 'ru',
                'NAME' => "Продукты на Wb.Market"
            ));

            $UFObject = 'HLBLOCK_' . $id;

            $arCartFields = array(
                'UF_VENDOR_ID' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_VENDOR_ID',
                    'USER_TYPE_ID' => 'string',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "UF_VENDOR_ID"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'UF_VENDOR_ID'),
                    "LIST_FILTER_LABEL" => array('ru' => 'UF_VENDOR_ID'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_NMID' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_NMID',
                    'USER_TYPE_ID' => 'string',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "UF_NMID"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'UF_NMID'),
                    "LIST_FILTER_LABEL" => array('ru' => 'UF_NMID'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_CREATED' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_CREATED',
                    'USER_TYPE_ID' => 'datetime',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "UF_CREATED"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'UF_CREATED'),
                    "LIST_FILTER_LABEL" => array('ru' => 'UF_CREATED'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
                'UF_UPDATE' => array(
                    'ENTITY_ID' => $UFObject,
                    'FIELD_NAME' => 'UF_UPDATE',
                    'USER_TYPE_ID' => 'datetime',
                    'MANDATORY' => 'N',
                    "EDIT_FORM_LABEL" => array('ru' => "UF_UPDATE"),
                    "LIST_COLUMN_LABEL" => array('ru' => 'UF_UPDATE'),
                    "LIST_FILTER_LABEL" => array('ru' => 'UF_UPDATE'),
                    "ERROR_MESSAGE" => array('ru' => '', 'en' => ''),
                    "HELP_MESSAGE" => array('ru' => '', 'en' => ''),
                ),
            );

            $arSavedFieldsRes = array();

            foreach ($arCartFields as $ufName => $arCartField) {
                $obUserField = new CUserTypeEntity;
                $ID = $obUserField->Add($arCartField);

                $arSavedFieldsRes[] = $ID;
            }

    }

    protected function DeleteOzonProductsTable() {
            $rs = \Bitrix\Highloadblock\HighloadBlockTable::getList([
                'filter' => ['NAME' => 'OzonProducts'],
                'select' => ['ID']
            ]);
            $ar = $rs->fetch();

            if($ar['ID']){
                Bitrix\Highloadblock\HighloadBlockTable::delete($ar['ID']);
            }
    //          else{
    //            $APPLICATION->ThrowException(
    //                "Не удалось удалить таблицы"
    //            );
    //            return false;
    //        }
    }

    protected function DeleteYandexProductsTable() {
            $rs = \Bitrix\Highloadblock\HighloadBlockTable::getList([
                'filter' => ['NAME' => 'YandexProducts'],
                'select' => ['ID']
            ]);
            $ar = $rs->fetch();

            if($ar['ID']){
                Bitrix\Highloadblock\HighloadBlockTable::delete($ar['ID']);
            }
    //          else{
    //            $APPLICATION->ThrowException(
    //                "Не удалось удалить таблицы"
    //            );
    //            return false;
    //        }
    }

     protected function DeleteWbProductsTable() {
            $rs = \Bitrix\Highloadblock\HighloadBlockTable::getList([
                'filter' => ['NAME' => 'WbProducts'],
                'select' => ['ID']
            ]);
            $ar = $rs->fetch();

            if($ar['ID']){
                Bitrix\Highloadblock\HighloadBlockTable::delete($ar['ID']);
            }
    //          else{
    //            $APPLICATION->ThrowException(
    //                "Не удалось удалить таблицы"
    //            );
    //            return false;
    //        }
    }
}