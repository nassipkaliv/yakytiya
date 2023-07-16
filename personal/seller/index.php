<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет производителя");
?><?$APPLICATION->IncludeComponent(
	"seller.section",
	"bootstrap_v5",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",  //Формат показа даты:
		"MAIN_CHAIN_NAME" => 'Кабинет производителя',
		"ORDERS_CHAIN_NAME" => 'Текущие заказы клиентов',
		"SEF_FOLDER" => "/personal/seller/", //Каталог ЧПУ (относительно корня сайта):
		"SEF_MODE" => "Y", //Включить поддержку ЧПУ:
		"SEF_URL_TEMPLATES" => array(
			"index"=>"index.php",  //Главная страница персонального раздела:
			"order_cancel"=>"cancel/#ID#",  //Страница отмены заказа:
			"order_detail"=>"orders/#ID#", //Страница подробной информации о заказе:
			"orders"=>"orders/",  //Страница заказов пользователя:
			"history"=>"history/",  //Страница заказов пользователя:
			"cancel"=>"cancel/",  //Страница заказов пользователя:
			"private"=>"private/",  //Страница персональных данных пользователя
		),
	)
);?>
	<?php
?>

<br>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>