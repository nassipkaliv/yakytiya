<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"ACTIVE" => array(
			"NAME" => 'Включено?',
			"PARENT" => "BASE",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"AUTOSLIDE" => array(
			"NAME" => 'Листание баннеров на таймере?',
			"PARENT" => "BASE",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		'IBLOCK_ID' => [
			"NAME" => 'ID инфоблока',
			"PARENT" => "BASE",
			"TYPE" => "STRING",
			"DEFAULT" => "4"
		]
	)
);
