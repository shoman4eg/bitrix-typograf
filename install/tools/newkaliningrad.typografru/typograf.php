<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$httpClient = new \Bitrix\Main\Web\HttpClient();
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$data['text'] = $request->get('text');
if (\Bitrix\Main\Application::getInstance()->isUtfMode()) {
    $data['chr'] = 'UTF-8';
}
$response = $httpClient->post('http://www.typograf.ru/webservice/', $data);
echo $response;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
