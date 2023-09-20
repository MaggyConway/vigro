<?

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (class_exists('sntinvest_integration'))
{
    return;
}

use Sntinvest\Integration\Events\OnUserEvent;
use Sntinvest\Integration\Events\OnProductEvent;
use Bitrix\Main\EventManager;

class sntinvest_integration extends CModule 
{
    var $MODULE_ID;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = 'Y';
    var $errors = '';

    private static $eventsList = [
//       [
//           'main',
//           'OnAfterUserAdd',
//           'sntinvest.integration',
//           OnUserEvent::class,
//           'handler'
//       ],
//       [
//           'main',
//           'OnAfterUserUpdate',
//           'sntinvest.integration',
//           OnUserEvent::class,
//           'handler'
//       ],
//       [
//           'iblock',
//           'OnAfterIBlockElementAdd',
//           'sntinvest.integration',
//           OnProductEvent::class,
//           'handler'
//       ],
//       [
//           'iblock',
//           'OnAfterIBlockElementUpdate',
//           'sntinvest.integration',
//           OnProductEvent::class,
//           'handler'
//       ],
    ];

    public function __construct() 
    {
        $arModuleVersion = array();
        
        include(__DIR__ . "/version.php");

        $this->MODULE_ID = 'sntinvest.integration';

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("SNTINVEST_INTEGRATION_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("SNTINVEST_INTEGRATION_MODULE_DESC");

        $this->PARTNER_NAME = Loc::getMessage("SNTINVEST_INTEGRATION_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("SNTINVEST_INTEGRATION_PARTNER_URI");

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
            $APPLICATION->ThrowException(Loc::getMessage("SNTINVEST_INTEGRATION_INSTALL_ERROR_VERSION"));
        }

        $APPLICATION->IncludeAdminFile(Loc::getMessage("SNTINVEST_INTEGRATION_INSTALL_TITLE"), $this->GetPath() . "/install/step.php");
    }

    public function DoUninstall()
    {
        global $APPLICATION;

        $this->UnInstallDB();
        $this->UnInstallEvents();
        
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(Loc::getMessage("SNTINVEST_INTEGRATION_UNINSTALL_TITLE"), $this->GetPath() . "/install/unstep.php");
    }
    
    public function InstallDB()
    {
    }

    public function UnInstallDB()
    {
    }
    
    public function InstallEvents()
    {
        $events = static::$eventsList;
        $eventManager = EventManager::getInstance(); 
        
        if (is_array($events) && count($events) > 0)
        {
            foreach ($events as $event)
            {
                list(
                    $moduleEvent,
                    $event,
                    $moduleSelf,
                    $class,
                    $method,
                ) = $event;
        
                 $eventManager->registerEventHandler(
                    $moduleEvent, 
                    $event, 
                    $moduleSelf, 
                    $class, 
                    $method,
                );
            }
        }
        
        return true;
    }

    public function UnInstallEvents()
    {
        $events = static::$eventsList;
        $eventManager = EventManager::getInstance(); 
        
        if (is_array($events) && count($events) > 0)
        {
            foreach ($events as $event)
            {
                list(
                    $moduleEvent,
                    $event,
                    $moduleSelf,
                    $class,
                    $method,
                ) = $event;
                
                $eventManager->unRegisterEventHandler(
                    $moduleEvent, 
                    $event, 
                    $moduleSelf, 
                    $class, 
                    $method,
                );
            }
        }
        
        return true;
    }

}

?>