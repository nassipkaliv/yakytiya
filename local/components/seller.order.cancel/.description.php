<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Отмена заказа",
	"DESCRIPTION" => "Позволяет отменить заказ",
	"ICON" => "/images/sale_order_cancel.gif",
	"PATH" => array(
		"ID" => "e-store",
		"CHILD" => array(
			"ID" => "sale_personal",
			"NAME" => "Персональный раздел"
		)
	),
);
?>