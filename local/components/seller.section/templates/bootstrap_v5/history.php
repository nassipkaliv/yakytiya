<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER;
global $APPLICATION;

if (!$USER->IsAuthorized())
{
	LocalRedirect($arResult['PATH_TO_AUTH_PAGE']);
}

if ($arParams["MAIN_CHAIN_NAME"] <> '')
{
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}

$APPLICATION->AddChainItem($arParams["ORDERS_CHAIN_NAME"], $arResult['PATH_TO_ORDERS']);

$APPLICATION->IncludeComponent(
	"seller.order.list",
	"bootstrap_v4",
	[
		"TYPE" => "ORDERS",
		"ACTIVE_DATE_FORMAT" => $arParams["ACTIVE_DATE_FORMAT"],
		"PATH_TO_DETAIL" => $arResult["PATH_TO_ORDER_DETAIL"],
		"PATH_TO_CANCEL" => $arResult["PATH_TO_ORDER_CANCEL"],
		"PATH_TO_CATALOG" => $arParams["PATH_TO_CATALOG"],
		"PATH_TO_BASKET" => $arParams["PATH_TO_BASKET"],
	],
	$component
);



