<?php
use Bitrix\Sale;
use Bitrix\Main\Application;

// Автозагрузка классов uchlib и lib
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/autoload.php")) {
	require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/autoload.php");
}

function OnSaleComponentOrderCreated($order, &$arUserResult, $request, &$arParams, &$arResult, &$arDeliveryServiceAll,&$arPaySystemServiceAll)
{
	//--{
	//при оформлении заказа нужно прокинуть в свойство заказа id производителя.
	//сейчас существует логика, что нельзя делать заказы со смешанными производителями
	//→ можно вытащить первый попавшийся товар и посмотреть его произваодителя
	$basketProductId = $order->getBasket()[0]->getField('PRODUCT_ID');
	$sellerData = \CU_Goods_Helper::getProductProducerData($basketProductId);
	if ($sellerData) {
		foreach ($order->getPropertyCollection() as $prop) {
			if ($prop->getField('CODE') == 'SELLER_ID') {
				$prop->setValue($sellerData['ID']);
				$order->doFinalAction(true);
				$result = $order->save();
				return;
			}
		}
	}
	//--}
}
AddEventHandler('sale', 'OnSaleComponentOrderCreated', 'OnSaleComponentOrderCreated');


/** подключать шаблон с вёрсткой?
 * @return bool
 */
function isAdaptiveActive()
{
	//где вёрстка?
	$designedPages = [
		'/',
		'/about/',
		'/about/contacts/',
	];

	$designedComplexPagesRegexps = [
		'/help/.*',
		'/news/.*',
        //'/search/.*'
	];

	//--{
	//чтобы руками можно было переиграть
	if ($_GET['adaptive'] === 'off') {
		return false;
	}
	if ($_GET['adaptive'] === 'on') {
		return true;
	}
	//--}

	$request = Application::getInstance()->getContext()->getRequest();
	// определяем находится ли пользователь в разделе, для которого необходимо использовать адаптивный шаблон
	$curDir =  $request->getRequestedPageDirectory();
	$curDirWithEndSlash = $curDir . '/';

	$exactMatch = in_array($curDirWithEndSlash, $designedPages);
	if ($exactMatch) {
		return true;
	}

	foreach ($designedComplexPagesRegexps as $regexp) {
		$regexpMatch = preg_match('|' . $regexp . '|', $curDirWithEndSlash);
		if ($regexpMatch) {
			return true;
		}
	}

	return false;
}

function isMainPage()
{
	$mainPage = '/';
	$request = Application::getInstance()->getContext()->getRequest();
	// определяем находится ли пользователь в разделе, для которого необходимо использовать адаптивный шаблон
	$curDir =  $request->getRequestedPageDirectory();
	$curDirWithEndSlash = $curDir . '/';
	return $curDirWithEndSlash == $mainPage;
}

function includeBitrixModules()
{
	\Bitrix\Main\Loader::includeModule('iblock');
	\Bitrix\Main\Loader::includeModule('sale');
}