<?

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (class_exists('silab_sitecore'))
{
    return;
}

use Bitrix\Main\EventManager;

class silab_sitecore extends CModule 
{
    var $MODULE_ID;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = 'Y';
    var $errors = '';

    public function __construct() 
    {
        $arModuleVersion = array();
        
        include(__DIR__ . "/version.php");

        $this->MODULE_ID = 'silab.sitecore';

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("SILAB_SITECODE_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("SILAB_SITECODE_MODULE_DESC");

        $this->PARTNER_NAME = Loc::getMessage("SILAB_SITECODE_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("SILAB_SITECODE_PARTNER_URI");

        $this->MODULE_SORT = 1;
        $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
        $this->MODULE_GROUP_RIGHTS = "Y";
    }

    public function GetPath() 
    {
        return dirname(__DIR__);
    }

    //Проверяем что система поддерживает D7
    public function isVersionD7()
    {
        return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
    }

    public function DoInstall() 
    {
        global $APPLICATION;

        if ($this->isVersionD7())
        {
            \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
            
            $this->InstallDB();
            $this->InstallEvents();
        }
        else 
        {
            $APPLICATION->ThrowException(Loc::getMessage("SILAB_SITECODE_INSTALL_ERROR_VERSION"));
        }

        $APPLICATION->IncludeAdminFile(Loc::getMessage("SILAB_SITECODE_INSTALL_TITLE"), $this->GetPath() . "/install/step.php");
    }

    public function DoUninstall()
    {
        global $APPLICATION;

        $this->UnInstallDB();
        $this->UnInstallEvents();
        
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(Loc::getMessage("SILAB_SITECODE_UNINSTALL_TITLE"), $this->GetPath() . "/install/unstep.php");
    }
    
    public function InstallDB()
    {
    }

    public function UnInstallDB()
    {
    }
    
    public function InstallEvents()
    {
    }

    public function UnInstallEvents()
    {
    }

}

?>