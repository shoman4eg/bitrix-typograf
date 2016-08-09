<?php
namespace Newkaliningrad\Typografru;

use Bitrix\Main\IO\Path;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Web\Json;

class Typograf
{
    public static function onBeforeHTMLEditorScriptRuns()
    {
        $asset = Asset::getInstance();
        $asset->addJs('/bitrix/js/newkaliningrad.typografru/typograf.js');

        $messages = Loc::loadLanguageFile(Path::normalize(__FILE__));
        $asset->addString(
            sprintf('<script>BX.message(%s)</script>',
                Json::encode($messages, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE)
            )
        );
    }
}
