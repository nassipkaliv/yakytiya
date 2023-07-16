<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

if($arParams["MAIN_CHAIN_NAME"] <> '')
{
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}
$APPLICATION->AddChainItem($arParams["ORDERS_CHAIN_NAME"], $arResult['PATH_TO_ORDERS']);
$APPLICATION->AddChainItem(str_replace("#ID#", $arResult["VARIABLES"]["ID"], "Отмена заказа №#ID#"));
$APPLICATION->IncludeComponent(
	"seller.order.cancel",
	"bootstrap_v5",
	array(
		"PATH_TO_LIST" => $arResult["PATH_TO_ORDERS"],
		"PATH_TO_DETAIL" => $arResult["PATH_TO_ORDER_DETAIL"],
		"AUTH_FORM_IN_TEMPLATE" => 'Y',
		"SET_TITLE" =>$arParams["SET_TITLE"],
		"ID" => $arResult["VARIABLES"]["ID"],
		"CONTEXT_SITE_ID" => $arParams["CONTEXT_SITE_ID"],
	),
	$component
);
?>
