<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
	"GROUPS" => array(
		"ORDER"    =>  array(
			"NAME"  =>  GetMessage("SPS_GROUP_ORDER"),
			"SORT"  =>  "520",
		),
		"PRIVATE"    =>  array(
			"NAME"  =>  GetMessage("SPS_GROUP_PRIVATE"),
			"SORT"  =>  "540",
		),
	),
	"PARAMETERS" => array(		
		"SEF_MODE" => array(
			"index" => array(
				"NAME" => GetMessage("SPS_MAIN_PERSONAL"),
				"DEFAULT" => "index.php",
				"VARIABLES" => array()
			),
			"orders" => array(
				"NAME" => GetMessage("SPS_GROUP_ORDER"),
				"DEFAULT" => "orders/",
				"VARIABLES" => array("ID")
			),
			"private" => array(
				"NAME" => GetMessage("SPS_GROUP_PRIVATE"),
				"DEFAULT" => "private/",
				"VARIABLES" => array("ID")
			),
			"order_detail" => array(
				"NAME" => GetMessage("SPS_DETAIL_DESC"),
				"DEFAULT" => "orders/#ID#",
				"VARIABLES" => array("ID")
			),			
			"order_cancel" => array(
				"NAME" => GetMessage("SPS_CANCEL_ORDER_DESC"),
				"DEFAULT" => "cancel/#ID#",
				"VARIABLES" => array("ID")
			),
		),		
		"SHOW_ORDER_PAGE" => array(
			"NAME" => GetMessage("SPS_SHOW_ORDER_PAGE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"PARENT" => "BASE",
			"REFRESH" => "Y"
		),
		"SHOW_PRIVATE_PAGE" => array(
			"NAME" => GetMessage("SPS_SHOW_PRIVATE_PAGE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"PARENT" => "BASE",
			"REFRESH" => "Y"
		),
		"SHOW_BASKET_PAGE" => array(
			"NAME" => GetMessage("SPS_SHOW_BASKET_PAGE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"PARENT" => "BASE",
			"REFRESH" => "Y"
		),
		"PATH_TO_BASKET" => array(
			"NAME" => GetMessage("SPS_PATH_TO_BASKET"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "/personal/cart/",
			"COLS" => 25,
			"PARENT" => "URL_TEMPLATES",
		),
		"PATH_TO_CATALOG" => array(
			"NAME" => GetMessage("SPS_PATH_TO_CATALOG"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "/catalog/",
			"COLS" => 25,
			"PARENT" => "URL_TEMPLATES",
		),
		"MAIN_CHAIN_NAME" => array(
			"NAME" => GetMessage("SPS_CHAIN_MAIN_FIELD"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => GetMessage("SPS_CHAIN_MAIN"),
			"COLS" => 25,
			"PARENT" => "ADDITIONAL_SETTINGS",
		),
		'SET_TITLE' => array(),		
		"CACHE_TIME"  =>  array("DEFAULT"=>3600),		
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("SPS_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		'CUSTOM_PAGES' => array(
			'NAME' => GetMessage('SPS_GROUP_CUSTOM'),
			'TYPE' => 'CUSTOM',
			'JS_FILE' => "/bitrix/components/bitrix/sale.personal.section/settings/settings.js",
			'JS_EVENT' => 'CustomSettingsEdit',
			'JS_DATA' => str_replace('\'',"\"", CUtil::PhpToJSObject(
				array(
					'labelName' => GetMessage('SPS_NAME_CUSTOM_PAGE'),
					'labelPath' => GetMessage('SPS_PATH_TO_CUSTOM_PAGE'),
					'labelIcon' => GetMessage('SPS_ICON_OF_CUSTOM_PAGE'),
				)
			)),
			'DEFAULT' => "",
			'PARENT' => 'BASE',
		)
	)
);

if ($arCurrentValues["SHOW_ORDER_PAGE"] !== "N")
{
	$arComponentParameters['PARAMETERS']['SAVE_IN_SESSION'] = array(
		"NAME" => GetMessage("SPS_SAVE_IN_SESSION"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
		"PARENT" => "ORDER",
	);

	if(CModule::IncludeModule("iblock"))
	{
		$arComponentParameters["PARAMETERS"]["ACTIVE_DATE_FORMAT"] = CIBlockParameters::GetDateFormat(GetMessage("SPS_ACTIVE_DATE_FORMAT"), "ORDER");

		$arComponentParameters["PARAMETERS"]["CUSTOM_SELECT_PROPS"] = array(
			"NAME" => GetMessage("SPS_PARAM_CUSTOM_SELECT_PROPS"),
			"TYPE" => "STRING",
			"MULTIPLE" => "Y",
			"VALUES" => array(),
			"PARENT" => "ORDER",
		);
	}

	if(CModule::IncludeModule("sale"))
	{
		$dbPerson = CSalePersonType::GetList(array("SORT" => "ASC", "NAME" => "ASC"));

		$userInfo = array(
			"LOGIN" => GetMessage("SPS_USER_INFO_LOGIN"),
			"EMAIL" => GetMessage("SPS_USER_INFO_EMAIL"),
			"PERSON_TYPE_NAME" => GetMessage("SPS_USER_INFO_PERSON_TYPE_NAME"),
			0 => GetMessage("SPS_SHOW_ALL"),
		);

		$arComponentParameters['PARAMETERS']['ORDER_HIDE_USER_INFO'] = array(
			"NAME" => GetMessage("SPS_ORDER_HIDE_USER_INFO"),
			"TYPE" => "LIST",
			"VALUES" => $userInfo,
			"MULTIPLE" => "Y",
			"DEFAULT" => 0,
			"PARENT" => "ORDER"
		);

		while($arPerson = $dbPerson->GetNext())
		{

			$arPers2Prop = array("" => GetMessage("SPS_SHOW_ALL"));
			$bProp = false;
			$dbProp = CSaleOrderProps::GetList(array("SORT" => "ASC", "NAME" => "ASC"), array("PERSON_TYPE_ID" => $arPerson["ID"]));
			while($arProp = $dbProp -> GetNext())
			{

				$arPers2Prop[$arProp["ID"]] = $arProp["NAME"];
				$bProp = true;
			}

			if($bProp)
			{
				$arComponentParameters["PARAMETERS"]["PROP_".$arPerson["ID"]] =  array(
					"NAME" => GetMessage("SPS_PROPS_NOT_SHOW")." \"".$arPerson["NAME"]."\" (".$arPerson["LID"].")",
					"TYPE"=>"LIST", "MULTIPLE"=>"Y",
					"VALUES" => $arPers2Prop,
					"DEFAULT"=>"",
					"COLS"=>25,
					"ADDITIONAL_VALUES"=>"N",
					"PARENT" => "ORDER",
				);
			}
		}

		$statusList = array();

		$listStatusNames = Bitrix\Sale\OrderStatus::getAllStatusesNames(LANGUAGE_ID);
		foreach($listStatusNames as $key => $data)
		{
			$statusList[$key] = $data;
		}

		$arComponentParameters['PARAMETERS']['ORDER_HISTORIC_STATUSES'] = array(
			"NAME" => GetMessage("SPS_HISTORIC_STATUSES"),
			"TYPE" => "LIST",
			"VALUES" => $statusList,
			"MULTIPLE" => "Y",
			"DEFAULT" => "F",
			"PARENT" => "ORDER",
		);

		array_unshift($statusList, GetMessage("SPS_NOT_CHOSEN"));

		$orderSortList = array(
			'STATUS' => GetMessage("SPS_ORDER_LIST_SORT_STATUS"),
			'ID' => GetMessage("SPS_ORDER_LIST_SORT_ID"),
			'ACCOUNT_NUMBER'=> GetMessage("SPS_ORDER_LIST_SORT_ACCOUNT_NUMBER"),
			'DATE_INSERT'=> GetMessage("SPS_ORDER_LIST_SORT_DATE_CREATE"),
			'PRICE'=> GetMessage("SPS_ORDER_LIST_SORT_PRICE")
		);

		$arComponentParameters['PARAMETERS']['ORDER_DEFAULT_SORT'] = array(
			"NAME" => GetMessage("SPS_ORDER_LIST_DEFAULT_SORT"),
			"TYPE" => "LIST",
			"VALUES" => $orderSortList,
			"MULTIPLE" => "N",
			"DEFAULT" => "STATUS",
			"PARENT" => "ORDER",
		);

		$arComponentParameters['PARAMETERS']['ORDER_DISALLOW_CANCEL'] = array(
			"NAME" => GetMessage("SPS_DISALLOW_CANCEL"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"PARENT" => "ORDER",
		);

		$arComponentParameters['PARAMETERS']['NAV_TEMPLATE'] = array(
			"NAME" => GetMessage("SPS_NAV_TEMPLATE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "ORDER",
		);

		$arComponentParameters['PARAMETERS']['ORDERS_PER_PAGE'] = array(
			"NAME" => GetMessage("SPS_ORDERS_PER_PAGE"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "20",
			"PARENT" => "ORDER",
		);
	}
}

if ($arCurrentValues["SHOW_PRIVATE_PAGE"] !== "N")
{
	$arComponentParameters["PARAMETERS"]["SEND_INFO_PRIVATE"] = array(
		"PARENT" => "PRIVATE",
		"NAME" => GetMessage("SPS_PRIVATE_SEND_INFO"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	);

	$arComponentParameters["PARAMETERS"]["CHECK_RIGHTS_PRIVATE"] = array(
		"PARENT" => "PRIVATE",
		"NAME" => GetMessage("SPS_PRIVATE_CHECK_RIGHTS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	);
}




