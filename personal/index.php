<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>

<?php $APPLICATION->IncludeComponent(
	"personal.section",
	"bootstrap_v4",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",  //Формат показа даты:
		"CACHE_GROUPS" => "Y", //CACHE_GROUPS
		"CACHE_TIME" => "3600", //Время кеширования (сек.):
		"CACHE_TYPE" => "A", //Тип кеширования:
		"CHECK_RIGHTS_PRIVATE" => "N", //Проверять права доступа
		"CUSTOM_PAGES" => "", //Путь к дополнительной странице
		"CUSTOM_SELECT_PROPS" => array(""),  //Дополнительные свойства инфоблока:
		"NAV_TEMPLATE" => "",  //Имя шаблона для постраничной навигации:
		"ORDER_HISTORIC_STATUSES" => array("F"), //Перенести в историю заказы в статусах:
		"PATH_TO_BASKET" => "/personal/cart",  //Путь к корзине:
		"PATH_TO_CATALOG" => "/catalog/",  //Путь к каталогу:
		"PATH_TO_CONTACT" => "/about/contacts", //Путь к странице контактных данных:
		"PER_PAGE" => "20",  //???? Количество профилей на одной странице
		"PROP_1" => array(), //Не показывать свойства для типа плательщика "Физическое лицо" (s1):
		"PROP_2" => array(),
		"SAVE_IN_SESSION" => "Y", //Сохранять установки фильтра в сессии пользователя:
		"SEF_FOLDER" => "/personal/", //Каталог ЧПУ (относительно корня сайта):
		"SEF_MODE" => "Y", //Включить поддержку ЧПУ:
		"SEF_URL_TEMPLATES" => array(
			"index"=>"index.php",  //Главная страница персонального раздела:
			"order_cancel"=>"cancel/#ID#",  //Страница отмены заказа:
			"order_detail"=>"orders/#ID#", //Страница подробной информации о заказе:
			"orders"=>"orders/",  //Страница заказов пользователя:
			"private"=>"private/",  //Страница персональных данных пользователя
		),
		"SEND_INFO_PRIVATE" => "N", //Генерировать почтовое событие:
		"SET_TITLE" => "Y", //Устанавливать заголовок страницы
		"SHOW_BASKET_PAGE" => "Y", //Вывести ссылку на корзину:
		"SHOW_ORDER_PAGE" => "Y", //Показать страницу заказов пользователя:
		"SHOW_PRIVATE_PAGE" => "Y", //Показать страницу персональных данных пользователя
		"USER_PROPERTY_PRIVATE" => array(),  // ?? (пустой)
	)
);?>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>