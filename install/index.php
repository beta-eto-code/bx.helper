<?

IncludeModuleLangFile(__FILE__);
use \Bitrix\Main\ModuleManager;

class bx_helper extends CModule
{
    public $MODULE_ID = "bx.helper";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $errors;

    public function __construct()
    {
        $this->MODULE_VERSION = "0.0.1";
        $this->MODULE_VERSION_DATE = "2022-07-11 19:49:41";
        $this->MODULE_NAME = "Название модуля";
        $this->MODULE_DESCRIPTION = "Описание модуля";
    }

    public function DoInstall()
    {
        ModuleManager::RegisterModule($this->MODULE_ID);
        return true;
    }

    public function DoUninstall()
    {
        ModuleManager::UnRegisterModule($this->MODULE_ID);
        return true;
    }
}
