<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

if (class_exists('newkaliningrad_typografru')) {
    return;
}

class newkaliningrad_typografru extends CModule
{
    /** @var string */
    public $MODULE_ID;

    /** @var string */
    public $MODULE_VERSION;

    /** @var string */
    public $MODULE_VERSION_DATE;

    /** @var string */
    public $MODULE_NAME;

    /** @var string */
    public $MODULE_DESCRIPTION;

    /** @var string */
    public $MODULE_GROUP_RIGHTS;

    /** @var string */
    public $PARTNER_NAME;

    /** @var string */
    public $PARTNER_URI;

    public function __construct()
    {
        $this->MODULE_ID = 'newkaliningrad.typografru';
        include(__DIR__ . '/version.php');
        if (isset($arModuleVersion) && is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        $this->MODULE_NAME = Loc::getMessage('NK_TYPOGRAF_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('NK_TYPOGRAF_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('NK_PARTNER_NAME');
        $this->PARTNER_URI = "https://www.newkaliningrad.ru";
    }

    public function InstallFiles() {

        $rootDir = Application::getDocumentRoot().'/'. ltrim(Application::getPersonalRoot(), '/');
        CopyDirFiles(__DIR__ . '/images' , $rootDir . '/images', true, true);
        CopyDirFiles(__DIR__ . '/js' , $rootDir . '/js', true, true);
        CopyDirFiles(__DIR__ . '/tools' , $rootDir . '/tools', true, true);
    }

    public function UnInstallFiles () {
        $files = array(
            'js' => '/js/' .$this->MODULE_ID,
            'img' => '/images/' .$this->MODULE_ID,
            'request' => '/tools/' .$this->MODULE_ID
        );
        $rootDir = Application::getDocumentRoot() . '/' . ltrim(Application::getPersonalRoot(), '/');

        foreach ($files as $file) {
            Directory::deleteDirectory($rootDir . $file);
        }
    }

    public function DoInstall()
    {
        $this->InstallFiles();
        ModuleManager::registerModule($this->MODULE_ID);
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible("fileman", "OnBeforeHTMLEditorScriptRuns", $this->MODULE_ID, '\Newkaliningrad\Typografru\Typograf', "onBeforeHTMLEditorScriptRuns");
    }

    public function DoUninstall()
    {
        $this->UnInstallFiles();
        ModuleManager::unRegisterModule($this->MODULE_ID);
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler("fileman", "OnBeforeHTMLEditorScriptRuns", $this->MODULE_ID, '\Newkaliningrad\Typografru\Typograf', "onBeforeHTMLEditorScriptRuns");
    }
}
