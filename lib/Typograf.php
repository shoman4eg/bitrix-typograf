<?php
namespace Newkaliningrad\Typografru;

use Bitrix\Main\Page\Asset;

class Typograf
{
    public static function onBeforeHTMLEditorScriptRuns()
    {
        Asset::getInstance()->addJs('/bitrix/js/newkaliningrad.typografru/typograf.js');
    }

}