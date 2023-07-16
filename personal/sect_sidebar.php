<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="bx-sidebar-block">
		<a href="/personal" class="list-group-item list-group-item-action" style="background-color: antiquewhite;text-align: center;"><b>Личный кабинет</b></a>
		<br>
	<?$APPLICATION->IncludeComponent("bitrix:menu", "personal_menu", array(
		"ROOT_MENU_TYPE" => "personal",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_TYPE" => "A",
		"CACHE_SELECTED_ITEMS" => "N",
		"MENU_CACHE_TIME" => "86400",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
		false
	);?>


	<div class="bx-sidebar-block">
		<a href="/personal/seller" class="list-group-item list-group-item-action" style="background-color: antiquewhite;text-align: center;"><b>Кабинет производителя</b></a>
		<br>
		<?$APPLICATION->IncludeComponent("bitrix:menu", "personal_menu", array(
			"ROOT_MENU_TYPE" => "seller",
			"MAX_LEVEL" => "1",
			"MENU_CACHE_TYPE" => "A",
			"CACHE_SELECTED_ITEMS" => "N",
			"MENU_CACHE_TIME" => "86400",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_CACHE_GET_VARS" => array(
			),
			"CHILD_MENU_TYPE" => "left",
			"USE_EXT" => "N",
			"DELAY" => "N",
			"ALLOW_MULTI_SELECT" => "N"
		),
			false
		);?>
	</div>
<div class="bx-sidebar-block">
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => SITE_DIR."include/socnet_sidebar.php",
			"AREA_FILE_RECURSIVE" => "N",
			"EDIT_MODE" => "html",
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
</div>

