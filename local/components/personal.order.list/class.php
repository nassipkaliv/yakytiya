<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage sale
 * @copyright 2001-2014 Bitrix
 */

use Bitrix\Main,
	Bitrix\Main\Config,
	Bitrix\Main\Localization,
	Bitrix\Main\Loader,
	Bitrix\Main\Data,
	Bitrix\Sale,
	Bitrix\Sale\Cashbox\CheckManager;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CBitrixPersonalOrderListComponent extends CBitrixComponent
{
	const E_SALE_MODULE_NOT_INSTALLED 		= 10000;
	const E_CANNOT_COPY_ORDER_NOT_FOUND		= 10001;
	const E_CANNOT_COPY_CANT_ADD_BASKET		= 10002;
	const E_CATALOG_MODULE_NOT_INSTALLED	= 10003;
	const E_NOT_AUTHORIZED					= 10004;

	/**
	 * Fatal error list. Any fatal error makes useless further execution of a component code.
	 * In most cases, there will be only one error in a list according to the scheme "one shot - one dead body"
	 *
	 * @var string[] Array of fatal errors.
	 */

	protected array $errorsFatal = array();
	/**
	 * Non-fatal error list. Some non-fatal errors may occur during component execution, so certain functions of the component
	 * may became defunct. Still, user should stay informed.
	 * There may be several non-fatal errors in a list.
	 *
	 * @var string[] Array of non-fatal errors.
	 */
	protected array $errorsNonFatal = array();

	/**
	 * Contains some valuable info from $_REQUEST
	 *
	 * @var object request info
	 */
	protected array|object $requestData = array();

	/**
	 * Gathered options that are required
	 *
	 * @var string[] options
	 */
	protected array $options = array();

	protected bool $useIblock = true;

	/**
	 * A value of current date format
	 *
	 * @var string format
	 */
	private string $dateFormat = '';

	/**
	 * Filter used when select orders
	 *
	 * @var mixed[] filter
	 */
	protected array $filter = array();

	/**
	 * Sort field for query
	 *
	 * @var string field
	 */
	protected $sortBy = false;

	/**
	 * Sort direction for query
	 *
	 * @var order: asc or desc
	 */
	protected $sortOrder = false;

	/**
	 * @var Sale\Registry registry
	 */
	protected Sale\Registry $registry;

	protected array $dbResult = array();
	private array $dbQueryResult = array();

	/**@var Data\Cache $this->currentCache */
	protected $currentCache = null;

	/**
	 * A convert map for method self::formatDate()
	 *
	 * @var string[] keys
	 */
	protected array $orderDateFields2Convert = array(
		'DATE_INSERT',
		'DATE_STATUS',
		'DATE_UPDATE',
		'PS_RESPONSE_DATE',
		'DATE_CANCELED'
	);

	/**
	 * A convert map for method self::formatDate()
	 *
	 * @var string[] keys
	 */
	protected array $basketDateFields2Convert = array(
		'DATE_INSERT',
		'DATE_UPDATE'
	);

	public function __construct($component = null)
	{
		parent::__construct($component);

		CPageOption::SetOptionString("main", "nav_page_in_session", "N");

		$this->dateFormat = Main\Context::getCurrent()->getCulture()->getDateTimeFormat();

		Localization\Loc::loadMessages(__FILE__);
	}

	/**
	 * Function checks if required modules installed. If not, throws an exception
	 * @return void
	 * @throws Main\SystemException|Main\LoaderException
	 */
	protected function checkRequiredModules():void
	{
		if (!Loader::includeModule('sale'))
			throw new Main\SystemException(Localization\Loc::getMessage("SPOL_SALE_MODULE_NOT_INSTALL"), self::E_SALE_MODULE_NOT_INSTALLED);

		if (!Loader::includeModule('iblock'))
			$this->useIblock = false;

	}

	/**
	 * Function checks if user is authorized or not. If not, auth form will be shown.
	 * @return void
	 * @throws Main\SystemException
	 */
	protected function checkAuthorized():void
	{
		global $USER;
		global $APPLICATION;

		if (!$USER->IsAuthorized())
		{
			$msg = Localization\Loc::getMessage("SPOL_ACCESS_DENIED");

			// for compatibility reasons: by default AuthForm() is shown in class.php, as it used to be.
			// BUT the better way is to show it in template.php, as it required by MVC paradigm
			if(!$this->arParams['AUTH_FORM_IN_TEMPLATE'])
			{
				$APPLICATION->AuthForm($msg, false, false, 'N', false);
			}

			throw new Main\SystemException($msg, self::E_NOT_AUTHORIZED);
		}
	}

	/**
	 * Function checks and prepares all the parameters passed. Everything about $arParam modification is here.
	 * @param mixed[] $arParams List of unchecked parameters
	 * @return mixed[] Checked and valid parameters
	 */
	public function onPrepareComponentParams($arParams): array
	{
		global $APPLICATION;

		self::tryParseInt($arParams["CACHE_TIME"], 3600, true);

		$arParams['CACHE_GROUPS'] = trim($arParams['CACHE_GROUPS']);
		if ('N' != $arParams['CACHE_GROUPS'])
			$arParams['CACHE_GROUPS'] = 'Y';

		self::tryParseString($arParams["PATH_TO_DETAIL"], $APPLICATION->GetCurPage()."?"."ID=#ID#");
		self::tryParseString($arParams["PATH_TO_CANCEL"], $APPLICATION->GetCurPage()."?"."ID=#ID#");
		self::tryParseString($arParams["PATH_TO_BASKET"], "basket.php");

		if ($arParams["SAVE_IN_SESSION"] != "N")
			$arParams["SAVE_IN_SESSION"] = "Y";

		if (!is_array($arParams['HISTORIC_STATUSES']) || empty($arParams['HISTORIC_STATUSES']))
			$arParams['HISTORIC_STATUSES'] = array('F');

		$arParams["NAV_TEMPLATE"] = ($arParams["NAV_TEMPLATE"] <> ''? $arParams["NAV_TEMPLATE"] : "");

		self::tryParseInt($arParams["ORDERS_PER_PAGE"], 20);
		self::tryParseString($arParams["ACTIVE_DATE_FORMAT"], "d.m.Y");

		self::tryParseBoolean($arParams['AUTH_FORM_IN_TEMPLATE']);

		if (empty($arParams['DEFAULT_SORT']))
		{
			$arParams['DEFAULT_SORT'] = 'STATUS';
		}

		return $arParams;
	}

	/**
	 * Function reduces input value to integer type, and, if gets null, passes the default value
	 * @param mixed $fld Field value
	 * @param int $default Default value
	 * @param int $allowZero Allows zero-value of the parameter
	 * @return int Parsed value
	 */
	public static function tryParseInt(&$fld, $default, $allowZero = null): int
	{
		$fld = intval($fld);
		if(!$allowZero && !$fld && isset($default))
			$fld = $default;

		return $fld;
	}

	/**
	 * Function processes string value and, if gets null, passes the default value to it
	 * @param mixed $fld Field value
	 * @param string $default Default value
	 * @return string parsed value
	 */
	public static function tryParseString(&$fld, $default): string
	{
		$fld = trim((string)$fld);
		if(!mb_strlen($fld) && isset($default))
			$fld = htmlspecialcharsbx($default);

		return $fld;
	}

	/**
	 * Function forces 'Y'/'N' value to boolean
	 * @param mixed $fld Field value
	 * @return string parsed value
	 */
	public static function tryParseBoolean(&$fld): bool|string
	{
		$fld = $fld == 'Y';
		return $fld;
	}

	/**
	 * Function sets page title, if required
	 * @return void
	 */
	protected function setTitle(): void
	{
		global $APPLICATION;

		if ($this->arParams["SET_TITLE"] == 'Y')
			$APPLICATION->SetTitle(Localization\Loc::getMessage("SPOL_DEFAULT_TITLE"));
	}

	/**
	 * Function gets all options required for component
	 * @return void
	 */
	protected function getOptions(): void
	{
		$this->options['USE_ACCOUNT_NUMBER'] = Sale\Integration\Numerator\NumeratorOrder::isUsedNumeratorForOrder();
	}

	/**
	 * Function processes and corrects $_REQUEST. Everything about $_REQUEST lies here.
	 * @return void
	 */
	protected function processRequest(): void
	{
		$this->requestData["ID"] = urldecode(urldecode($this->arParams["ID"]));

		if($_REQUEST["del_filter"] <> '')
		{
			unset($_REQUEST["filter_id"]);
			unset($_REQUEST["filter_date_from"]);
			unset($_REQUEST["filter_date_to"]);
			unset($_REQUEST["filter_status"]);
			unset($_REQUEST["filter_payed"]);
			unset($_REQUEST["filter_canceled"]);
			$_REQUEST["filter_history"] = "Y";
			if($this->arParams["SAVE_IN_SESSION"] == "Y")
			{
				unset($_SESSION["spo_filter_id"]);
				unset($_SESSION["spo_filter_date_from"]);
				unset($_SESSION["spo_filter_date_to"]);
				unset($_SESSION["spo_filter_status"]);
				unset($_SESSION["spo_filter_payed"]);
				unset($_SESSION["spo_filter_canceled"]);
				$_SESSION["spo_filter_history"] = "Y";
			}
		}

		$this->filterRestore();
		$this->filterStore();

		$orderClassName = $this->registry->getOrderClassName();
		$tableFieldNameList = $orderClassName::getAllFields();

		if (isset($_REQUEST["by"]) && strval($_REQUEST['by']) != '')
		{
			if (!in_array($_REQUEST['by'], $tableFieldNameList))
				$_REQUEST["by"] = $this->arParams['DEFAULT_SORT'];
		}

		$this->sortBy = ($_REQUEST["by"] <> ''? $_REQUEST["by"] : $this->arParams['DEFAULT_SORT']);
		$this->sortOrder = (mb_strlen($_REQUEST["order"]) != "" && $_REQUEST["order"] == "ASC" ? "ASC": "DESC");

		$this->prepareFilter();
	}

	/**
	 * Read filter from session (or anywhere else), if required
	 * @return void
	 */
	protected function filterRestore(): void
	{
		if ($this->arParams["SAVE_IN_SESSION"] == "Y" && !mb_strlen($_REQUEST["filter"]))
		{
			if (intval($_SESSION["spo_filter_id"]))
				$_REQUEST["filter_id"] = $_SESSION["spo_filter_id"];
			if($_SESSION["spo_filter_date_from"] <> '')
			{
				$_REQUEST["filter_date_from"] = $_SESSION["spo_filter_date_from"];
			}
			if($_SESSION["spo_filter_date_to"] <> '')
			{
				$_REQUEST["filter_date_to"] = $_SESSION["spo_filter_date_to"];
			}
			if($_SESSION["spo_filter_status"] <> '')
			{
				$_REQUEST["filter_status"] = $_SESSION["spo_filter_status"];
			}
			if($_SESSION["spo_filter_payed"] <> '')
			{
				$_REQUEST["filter_payed"] = $_SESSION["spo_filter_payed"];
			}
			if($_SESSION["spo_filter_canceled"] <> '')
			{
				$_REQUEST["filter_canceled"] = $_SESSION["spo_filter_canceled"];
			}
			if ($_SESSION["spo_filter_history"] == "Y")
				$_REQUEST["filter_history"] = "Y";
		}
	}

	/**
	 * Store filter in session (or anywhere else), if required.
	 * @return void
	 */
	protected function filterStore(): void
	{
		if ($this->arParams["SAVE_IN_SESSION"] == "Y" && mb_strlen($_REQUEST["filter"]))
		{
			$_SESSION["spo_filter_id"] = $_REQUEST["filter_id"];
			$_SESSION["spo_filter_date_from"] = $_REQUEST["filter_date_from"];
			$_SESSION["spo_filter_date_to"] = $_REQUEST["filter_date_to"];
			$_SESSION["spo_filter_status"] = $_REQUEST["filter_status"];
			$_SESSION["spo_filter_payed"] = $_REQUEST["filter_payed"];
			$_SESSION["spo_filter_history"] = $_REQUEST["filter_history"];
		}
	}

	/**
	 * Creates filter for CSaleOrder::GetList() based on $_REQUEST and other parameters
	 * @return void
	 */
	protected function prepareFilter(): void
	{
		global $USER;
		global $DB;

		$arFilter = array();
		$arFilter["USER_ID"] = $USER->GetID();
		$arFilter["LID"] = SITE_ID;

		if($_REQUEST["filter_id"] <> '')
		{
			if($this->options['USE_ACCOUNT_NUMBER'])
			{
				$arFilter["ACCOUNT_NUMBER"] = $_REQUEST["filter_id"];
			}
			else
			{
				$arFilter["ID"] = intval($_REQUEST["filter_id"]);
			}
		}

		if($_REQUEST["filter_date_from"] <> '')
		{
			$arFilter[">=DATE_INSERT"] = trim($_REQUEST["filter_date_from"]);
		}

		if($_REQUEST["filter_date_to"] <> '')
		{
			$arFilter["<=DATE_INSERT"] = trim($_REQUEST["filter_date_to"]);

			if($arDate = ParseDateTime(trim($_REQUEST["filter_date_to"]), $this->dateFormat))
			{
				if(mb_strlen(trim($_REQUEST["filter_date_to"])) < 11)
				{
					$arDate["HH"] = 23;
					$arDate["MI"] = 59;
					$arDate["SS"] = 59;
				}

				$arFilter["<=DATE_INSERT"] = date($DB->DateFormatToPHP($this->dateFormat), mktime($arDate["HH"], $arDate["MI"], $arDate["SS"], $arDate["MM"], $arDate["DD"], $arDate["YYYY"]));
			}
		}

		if($_REQUEST["filter_status"] <> '')
		{
			$arFilter["STATUS_ID"] = trim($_REQUEST["filter_status"]);
		}

		if($_REQUEST["filter_payed"] <> '')
		{
			$arFilter["PAYED"] = trim($_REQUEST["filter_payed"]);
		}

		if (!isset($_REQUEST['show_all']) || $_REQUEST['show_all'] == 'N')
		{
			if (isset($_REQUEST["filter_history"]) && $_REQUEST["filter_history"] == "Y")
			{
				if ($_REQUEST["show_canceled"] == "Y")
				{
					$arFilter['CANCELED'] = 'Y';
				}
				else
				{
					$arFilter[] = array(
						'@STATUS_ID' => $this->arParams['HISTORIC_STATUSES']
					);
				}
			}
			else
			{
				$arFilter[] = array(
					'!@STATUS_ID' => $this->arParams['HISTORIC_STATUSES'],
					'CANCELED' => 'N'
				);
			}
		}

		if($_REQUEST["filter_canceled"] <> '')
		{
			$arFilter["CANCELED"] = trim($_REQUEST["filter_canceled"]);
		}

		$this->filter = $arFilter;
	}


	/**
	 * Read some data from database, using cache. Under some info we mean status list, delivery system list and so on.
	 * This will be a shared cache between sale.personal.order.list and sale.personal.order.detail, so beware of collisions.
	 * @return void
	 * @throws Exception
	 * @throws Main\SystemException
	 */
	protected function obtainDataReferences(): void
	{
		if ($this->startCache(array('spo-shared')))
		{
			try
			{
				$cachedData = array();

				/////////////////////
				/////////////////////

				// Person type
				$cachedData['PERSON_TYPE'] = array();

				$personTypeClassName = $this->registry->getPersonTypeClassName();
				$cachedData['PERSON_TYPE'] = $personTypeClassName::load(SITE_ID);

				// Save statuses for Filter form
				$cachedData['STATUS'] = array();

				$orderStatusClassName = $this->registry->getOrderStatusClassName();
				$listStatusNames = $orderStatusClassName::getAllStatusesNames(LANGUAGE_ID);

				foreach($listStatusNames as $key => $data)
				{
					$cachedData['STATUS'][$key] = array('ID'=>$key,'NAME'=>$data);
				}

				/////////////////////
				/////////////////////

			}
			catch (Exception $e)
			{
				$this->abortCache();
				throw $e;
			}

			$this->endCache($cachedData);

		}
		else
			$cachedData = $this->getCacheData();

		$this->dbResult = array_merge($this->dbResult, $cachedData);
	}

	/**
	 * Perform reading main data from database, no cache is used
	 * @return void
	 */
	protected function obtainDataOrders(): void
	{
		$listOrders = array();
		$orderIdList = array();
		$listOrderBasket = array();

		$select = array(
				'ID',
				'LID',
				'PERSON_TYPE_ID',

				'PAYED',
				'DATE_PAYED',
				'EMP_PAYED_ID',

				'CANCELED',
				'DATE_CANCELED',
				'EMP_CANCELED_ID',
				'REASON_CANCELED',

				'MARKED',
				'DATE_MARKED',
				'EMP_MARKED_ID',
				'REASON_MARKED',

				'STATUS_ID',
				'DATE_STATUS',

				'PAY_VOUCHER_NUM',
				'PAY_VOUCHER_DATE',
				'EMP_STATUS_ID',

				'RESERVED',
				'PRICE',
				'CURRENCY',
				'DISCOUNT_VALUE',

				'SUM_PAID',
				'USER_ID',

				'DATE_INSERT',
				'DATE_UPDATE',

				'USER_DESCRIPTION',
				'ADDITIONAL_INFO',

				'ACCOUNT_NUMBER',
				'XML_ID'
		);

		$getListParams = array(
			'filter' => $this->filter,
			'select' => $select
		);

		if ($this->sortBy == 'STATUS')
		{
			$getListParams['runtime'] = array(
				new Main\Entity\ReferenceField(
					'STATUS',
					'\Bitrix\Sale\Internals\StatusTable',
					array(
						'=this.STATUS_ID' => 'ref.ID',
					),
					array(
						"join_type" => 'inner'
					)
				)
			);
			$getListParams['order'] = array("STATUS.SORT" => 'ASC', 'ID' => $this->sortOrder);
		}
		else
		{
			$getListParams['order'] = array($this->sortBy => $this->sortOrder);
		}

		if (isset($this->arParams['CONTEXT_SITE_ID']) && $this->arParams['CONTEXT_SITE_ID'] > 0)
		{
			$code = \Bitrix\Sale\TradingPlatform\Landing\Landing::getCodeBySiteId($this->arParams['CONTEXT_SITE_ID']);
			$platformId = \Bitrix\Sale\TradingPlatform\Landing\Landing::getInstanceByCode($code)->getId();
			if ((int)$platformId > 0)
			{
				$getListParams['runtime'][] = new Main\ORM\Fields\Relations\Reference(
					'TRADING_BINDING',
					'\Bitrix\Sale\TradingPlatform\OrderTable',
					array(
						'=this.ID' => 'ref.ORDER_ID',
						'=ref.TRADING_PLATFORM_ID' => new Main\DB\SqlExpression('?i', $platformId)
					),
					array(
						"join_type" => 'inner'
					)
				);
				$getListParams['runtime'][] = new Main\ORM\Fields\Relations\Reference(
					'TRADING',
					'\Bitrix\Sale\TradingPlatformTable',
					array(
						'=this.TRADING_BINDING.TRADING_PLATFORM_ID' => 'ref.ID',
						'=ref.CLASS' => new Main\DB\SqlExpression('?', "\\".Sale\TradingPlatform\Landing\Landing::class)
					),
					array(
						"join_type" => 'inner'
					)
				);
			}
		}

		$usePageNavigation = true;

		$totalPages = 0;
		$totalCount = 0;

		$orderClassName = $this->registry->getOrderClassName();

		\CPageOption::SetOptionString("main", "nav_page_in_session", "N");
		$navyParams = \CDBResult::GetNavParams();

		if ($navyParams['SHOW_ALL'])
		{
			$usePageNavigation = false;
		}
		else
		{
			$navyParams['PAGEN'] = (int)$navyParams['PAGEN'];
			$navyParams['SIZEN'] = (int)$navyParams['SIZEN'];
			if (isset($this->arParams["ORDERS_PER_PAGE"]) && intval($this->arParams["ORDERS_PER_PAGE"]) > 0)
			{
				$navyParams['SIZEN'] = $this->arParams["ORDERS_PER_PAGE"];
			}

			$getListParams['limit'] = $navyParams['SIZEN'];
			$getListParams['offset'] = $navyParams['SIZEN']*($navyParams['PAGEN']-1);

			$countParams = [
				"filter"=>$getListParams['filter'],
				"select"=> [new Main\ORM\Fields\ExpressionField('CNT', 'COUNT(1)')]
			];

			if (!empty($getListParams['runtime']))
			{
				$countParams["runtime"] = $getListParams['runtime'];
			}

			/** @var Main\DB\Result $countQuery */
			$countQuery = $orderClassName::getList($countParams);

			$totalCount = $countQuery->fetch();
			$totalCount = (int)$totalCount['CNT'];
			unset($countQuery);

			if ($totalCount > 0)
			{
				$totalPages = ceil($totalCount/$navyParams['SIZEN']);

				if ($navyParams['PAGEN'] > $totalPages)
					$navyParams['PAGEN'] = $totalPages;

				$getListParams['limit'] = $navyParams['SIZEN'];
				$getListParams['offset'] = $navyParams['SIZEN']*($navyParams['PAGEN']-1);
			}
			else
			{
				$navyParams['PAGEN'] = 1;
				$getListParams['limit'] = $navyParams['SIZEN'];
				$getListParams['offset'] = 0;
			}
		}

		$this->dbQueryResult['ORDERS'] = new \CDBResult($orderClassName::getList($getListParams));

		if ($usePageNavigation)
		{
			$this->dbQueryResult['ORDERS']->NavStart($getListParams['limit'], $navyParams['SHOW_ALL'], $navyParams['PAGEN']);
			$this->dbQueryResult['ORDERS']->NavRecordCount = $totalCount;
			$this->dbQueryResult['ORDERS']->NavPageCount = $totalPages;
			$this->dbQueryResult['ORDERS']->NavPageNomer = $navyParams['PAGEN'];
		}
		else
		{
			if ((int)($this->arParams["ORDERS_PER_PAGE"]))
			{
				$this->dbQueryResult['ORDERS']->NavStart($this->arParams["ORDERS_PER_PAGE"], false);
			}
		}

		if (empty($this->dbQueryResult['ORDERS']))
		{
			return;
		}

		while ($arOrder = $this->dbQueryResult['ORDERS']->GetNext())
		{
			$listOrders[$arOrder["ID"]] = $arOrder;
			$orderIdList[] = $arOrder["ID"];
		}

		$basketClassName = $this->registry->getBasketClassName();
		/** @var Main\DB\Result $listBaskets */
		$listBaskets = $basketClassName::getList(array(
			'select' => array("*"),
			'filter' => array("ORDER_ID" => $orderIdList),
			'order' => array('NAME' => 'asc')
		));

		while ($basket = $listBaskets->fetch())
		{
			if (CSaleBasketHelper::isSetItem($basket))
				continue;

			$listOrderBasket[$basket['ORDER_ID']][$basket['ID']] = $basket;
		}

		foreach ($orderIdList as $orderId)
		{
			$this->dbResult['ORDERS'][] = array(
				"ORDER" => $listOrders[$orderId],
				"BASKET_ITEMS" => $listOrderBasket[$orderId],
			);
		}
	}

	/**
	 * Fetches all required data from database. Everything that connected with data fetch is here.
	 * @return void
	 * @throws Main\SystemException
	 */
	protected function obtainData(): void
	{
		$this->obtainDataReferences();
		$this->obtainDataOrders();
	}

	/**
	 * Move data read from database to a specially formatted $arResult
	 * @return void
	 */
	protected function formatResult(): void
	{
		global $APPLICATION;

		$arResult = array();

		// references
		$arResult["INFO"]["STATUS"] = $this->dbResult['STATUS'];

		$arResult["CURRENT_PAGE"] = $APPLICATION->GetCurPage();
		$arResult["NAV_STRING"] = $this->dbQueryResult['ORDERS']->GetPageNavString(Localization\Loc::getMessage("SPOL_PAGES"), $this->arParams["NAV_TEMPLATE"]);

		// bug walkaround
		$this->arParams["PATH_TO_CANCEL"] .= (mb_strpos($this->arParams["PATH_TO_CANCEL"], "?") === false ? "?" : "&");
		if (empty($this->arParams["PATH_TO_CATALOG"]))
		{
			$this->arParams["PATH_TO_CATALOG"] = '/catalog/';
		}

		if(self::isNonemptyArray($this->dbResult['ORDERS']))
		{
			foreach ($this->dbResult['ORDERS'] as $k => $orderInfo)
			{
				$arOrder =& $this->dbResult['ORDERS'][$k]['ORDER'];

				$arOBasket =& $this->dbResult['ORDERS'][$k]['BASKET_ITEMS'];

				$arOrder["FORMATED_PRICE"] = SaleFormatCurrency($arOrder["PRICE"], $arOrder["CURRENCY"]);

				$this->formatDate($arOrder, $this->orderDateFields2Convert);

				if ($this->arParams['DISALLOW_CANCEL'] === 'Y')
				{
					$arOrder["CAN_CANCEL"] = 'N';
				}
				else
				{
					$arOrder["CAN_CANCEL"] = ($arOrder["CANCELED"] != "Y" && $arOrder["STATUS_ID"] != "F" && $arOrder["PAYED"] != "Y") ? "Y" : "N";
				}

				$arOrder["URL_TO_DETAIL"] = CComponentEngine::makePathFromTemplate($this->arParams["PATH_TO_DETAIL"], array("ID" => urlencode(urlencode($arOrder["ACCOUNT_NUMBER"]))));
				$arOrder["URL_TO_CANCEL"] = CComponentEngine::makePathFromTemplate($this->arParams["PATH_TO_CANCEL"], array("ID" => urlencode(urlencode($arOrder["ACCOUNT_NUMBER"]))))."CANCEL=Y";

				if(self::isNonemptyArray($arOBasket))
				{
					foreach ($arOBasket as $n => $basketInfo)
					{
						$arBasket =& $arOBasket[$n];

						$arBasket["NAME~"] = $arBasket["NAME"];
						$arBasket["NOTES~"] = $arBasket["NOTES"];
						$arBasket["NAME"] = htmlspecialcharsEx($arBasket["NAME"]);
						$arBasket["NOTES"] = htmlspecialcharsEx($arBasket["NOTES"]);
						$arBasket["QUANTITY"] = doubleval($arBasket["QUANTITY"]);

						// backward compatibility
						$arBasket["MEASURE_TEXT"] = $arBasket["MEASURE_NAME"];

						$this->formatDate($arBasket, $this->basketDateFields2Convert);
					}
				}
			}

			$arResult["ORDERS"] = $this->dbResult['ORDERS'];
		}
		else
		{
			$arResult["ORDERS"] = array();
		}
		$arResult['SORT_TYPE'] = $this->sortBy;

		$this->arResult = $arResult;
	}

	/**
	 * Move all errors to $arResult, if there were any
	 * @return void
	 */
	protected function formatResultErrors(): void
	{
		$errors = array();
		if (!empty($this->errorsFatal))
			$errors['FATAL'] = $this->errorsFatal;
		if (!empty($this->errorsNonFatal))
			$errors['NONFATAL'] = $this->errorsNonFatal;

		if (!empty($errors))
			$this->arResult['ERRORS'] = $errors;

		// backward compatiblity
		$error = current($this->errorsFatal);
		if (!empty($error))
			$this->arResult['ERROR_MESSAGE'] = $error;
	}

	/**
	 * Function implements all the life cycle of our component
	 * @return void
	 */
	public function executeComponent(): void
	{
		try
		{
			$this->setFrameMode(false);
			$this->checkRequiredModules();
			$this->checkAuthorized();
			$this->setTitle();
			$this->getOptions();
			$this->setRegistry();
			$this->processRequest();

			$this->obtainData();
			$this->formatResult();

		}

		catch (Exception $e)
		{
			$this->errorsFatal[$e->getCode()] = $e->getMessage();
		}

		$this->formatResultErrors();

		$this->includeComponentTemplate();
	}

	/**
	 * Return current class registry
	 *
	 * @param mixed[] array that date conversion performs in
	 * @return void
	 */
	protected function setRegistry(): void
	{
		$this->registry = Sale\Registry::getInstance(Sale\Registry::REGISTRY_TYPE_ORDER);
	}

	/**
	 * Convert dates if date template set
	 * @param mixed[] $arr data array to be converted
	 * @param string[] $conversion contains sublist of keys of $arr, that will be converted
	 * @return void
	 */
	protected function formatDate(&$arr, $conversion): void
	{
		if (!$this->useIblock)
			return;
		if (mb_strlen($this->arParams['ACTIVE_DATE_FORMAT']) && self::isNonemptyArray($conversion))
			foreach ($conversion as $fld)
			{
				if (!empty($arr[$fld]))
					$arr[$fld."_FORMATED"] = CIBlockFormatProperties::DateFormat($this->arParams['ACTIVE_DATE_FORMAT'], MakeTimeStamp($arr[$fld]));
			}
	}

	/**
	 * Function checks if it`s argument is a legal array for foreach() construction
	 * @param mixed $arr data to check
	 * @return boolean
	 */
	protected static function isNonemptyArray($arr): bool
	{
		return is_array($arr) && !empty($arr);
	}

	////////////////////////
	// Cache functions
	////////////////////////
	/**
	 * Function checks if cacheing is enabled in component parameters
	 * @return boolean
	 */
	final protected function getCacheNeed(): bool
	{
		return	intval($this->arParams['CACHE_TIME']) > 0 &&
				$this->arParams['CACHE_TYPE'] != 'N' &&
				Config\Option::get("main", "component_cache_on", "Y") == "Y";
	}

	/**
	 * Function perform start of cache process, if needed
	 * @param mixed[]|string $cacheId An optional addition for cache key
	 * @return boolean True, if cache content needs to be generated, false if cache is valid and can be read
	 */
	final protected function startCache($cacheId = array()): bool
	{
		if(!$this->getCacheNeed())
			return true;

		$this->currentCache = Data\Cache::createInstance();

		return $this->currentCache->startDataCache(intval($this->arParams['CACHE_TIME']), $this->getCacheKey($cacheId));
	}

	/**
	 * Function perform start of cache process, if needed
	 * @throws Main\SystemException
	 * @param mixed[] $data Data to be stored in the cache
	 * @return void
	 */
	final protected function endCache($data = null): void
	{
		if(!$this->getCacheNeed())
			return;

		if($this->currentCache == 'null')
			throw new Main\SystemException('Cache were not started');

		$this->currentCache->endDataCache($data);
		$this->currentCache = null;
	}

	/**
	 * Function discard cache generation
	 * @throws Main\SystemException
	 * @return void
	 */
	final protected function abortCache(): void
	{
		if(!$this->getCacheNeed())
			return;

		if($this->currentCache == 'null')
			throw new Main\SystemException('Cache were not started');

		$this->currentCache->abortDataCache();
		$this->currentCache = null;
	}

	/**
	 * Function return data stored in cache
	 * @throws Main\SystemException
	 * @return bool|mixed[] Data from cache
	 */
	final protected function getCacheData(): array|bool
	{
		if(!$this->getCacheNeed())
		{
			return false;
		}

		if($this->currentCache == 'null')
			throw new Main\SystemException('Cache were not started');

		return $this->currentCache->getVars();
	}

	/**
	 * Function leaves the ability to modify cache key in future.
	 * @param array $cacheId
	 * @return string Cache key to be used in CPHPCache()
	 */
	final protected function getCacheKey($cacheId = array()): string
	{
		if(!is_array($cacheId))
			$cacheId = array((string) $cacheId);

		$cacheId['SITE_ID'] = SITE_ID;
		$cacheId['LANGUAGE_ID'] = LANGUAGE_ID;
		// if there are two or more caches with the same id, but with different cache_time, make them separate
		$cacheId['CACHE_TIME'] = intval($this->arResult['CACHE_TIME']);

		if(defined("SITE_TEMPLATE_ID"))
			$cacheId['SITE_TEMPLATE_ID'] = SITE_TEMPLATE_ID;

		return implode('|', $cacheId);
	}
}
