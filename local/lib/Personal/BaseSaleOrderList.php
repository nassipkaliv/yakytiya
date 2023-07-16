<?php
namespace lib\Personal;

use Bitrix\Main,
    Bitrix\Main\Loader,
    Bitrix\Sale,
    Bitrix\Main\ArgumentException,
    Bitrix\Main\LoaderException,
    Bitrix\Main\SystemException;
use CComponentEngine;
use CDBResult;
use CSaleBasketHelper;

abstract class BaseSaleOrderList
{
	use HasFormatDate, HasNonemptyArray;

	const ACTIVE_DATE_FORMAT = "d.m.Y";

	/**
	 * Filter used when select orders
	 */
	protected array $filter = [];
	protected array $select = [];
	protected array $dbQueryResult = [];

	protected array $dbResult = [];

	protected string $urlToDetail = '';

	protected string $urlToCancel = '';

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
     * @throws SystemException
	 * @throws ArgumentException
	 */
	public function exec(): array
	{
		$this->obtainData();
		return $this->formatResult();
	}
    /**
     * @throws LoaderException
     * @throws SystemException
     */
    protected function checkRequiredModules(): void
    {
        if (!Loader::includeModule('sale')) {
            throw new Main\SystemException('Модуль "Интернет-магазин" не установлен');
        }

        if (!Loader::includeModule('iblock')) {
            throw new Main\SystemException('Модуль "Информационные блоки" не установлен');
        }
    }

    /**
     * @throws ArgumentException
     */
    protected function setRegistry(): void
    {
        $this->instanceOrderRegister = Sale\Registry::getInstance(Sale\Registry::REGISTRY_TYPE_ORDER);
    }

    /**
     * @throws SystemException
     * @throws LoaderException
     */
	protected function obtainData(): void
	{
        $this->checkRequiredModules();
        $this->setRegistry();
		$this->obtainDataReferences();
		$this->obtainDataOrders();
	}


	/**
	 * Прочитать некоторые данные из базы данных, используя кеш.
	 * Это будет общий кеш между seller.order.list и seller.order.detail, так что остерегайтесь коллизий.
	 * @return void
	 * @throws Main\SystemException
	 */
	protected function obtainDataReferences(): void
	{
		// Save statuses for Filter form
		$this->dbResult['STATUS'] = [];
		$orderStatusClassName = $this->instanceOrderRegister->getOrderStatusClassName();
		$listStatusNames = $orderStatusClassName::getAllStatusesNames(LANGUAGE_ID);
		foreach ($listStatusNames as $key => $data) {
			$this->dbResult['STATUS'][$key] = ['ID' => $key, 'NAME' => $data];
		}
	}

	/**
	 * Perform reading main data from database, no cache is used
	 * @return void
	 * @throws Main\SystemException
	 */
	protected function obtainDataOrders(): void
	{
		$listOrders = [];

		$listOrderBasket = [];

		$getListParams = [
			'filter' => $this->filter,
			'select' => $this->select
		];


		$orderClassName = $this->instanceOrderRegister->getOrderClassName();
		$this->dbQueryResult['ORDERS'] = new CDBResult($orderClassName::getList($getListParams));


		if (empty($this->dbQueryResult['ORDERS'])) {
			return;
		}

		$orderIdList = [];
		while ($arOrder = $this->dbQueryResult['ORDERS']->GetNext()) {
			$listOrders[$arOrder["ID"]] = $arOrder;
			$orderIdList[] = $arOrder["ID"];
		}

		$basketClassName = $this->instanceOrderRegister->getBasketClassName();
		/** @var Main\DB\Result $listBaskets */
		$listBaskets = $basketClassName::getList(array(
			"select" => ["*"],
			"filter" => ["ORDER_ID" => $orderIdList],
			"order" => ["NAME" => "asc"]
		));

		while ($basket = $listBaskets->fetch()) {
			if (CSaleBasketHelper::isSetItem($basket)) {
				continue;
			}

			$listOrderBasket[$basket['ORDER_ID']][$basket['ID']] = $basket;
		}

		foreach ($orderIdList as $orderId) {
			$this->dbResult['ORDERS'][] = [
				"ORDER" => $listOrders[$orderId],
				"BASKET_ITEMS" => $listOrderBasket[$orderId],
			];
		}
	}


	/**
	 * Move data read from database to a specially formatted $arResult
	 * @return array
	 */
	protected function formatResult(): array
	{
		$arResult["INFO"]["STATUS"] = $this->dbResult['STATUS'];

		if (self::isNonemptyArray($this->dbResult['ORDERS'])) {
			foreach ($this->dbResult['ORDERS'] as $k => $orderInfo) {
				$arOrder =& $this->dbResult['ORDERS'][$k]['ORDER'];
				$statusID = $arOrder['STATUS_ID'];
				$arOrder["FORMATTED_STATUS_NAME"] = htmlspecialcharsbx($this->dbResult['STATUS'][$statusID]['NAME']);
				$arOrder["FORMATTED_PRICE"] = SaleFormatCurrency($arOrder["PRICE"], $arOrder["CURRENCY"]);
				$arOrder["CAN_CANCEL"] = ($arOrder["CANCELED"] != "Y" && $arOrder["STATUS_ID"] != "F" && $arOrder["PAYED"] != "Y") ? "Y" : "N";

				if(mb_strlen($this->urlToDetail)) {
					$arOrder["URL_TO_DETAIL"] = CComponentEngine::makePathFromTemplate($this->urlToDetail, ["ID" => urlencode($arOrder["ID"])]);
				}
				if(mb_strlen($this->urlToCancel)) {
					$arOrder["URL_TO_CANCEL"] = CComponentEngine::makePathFromTemplate($this->urlToCancel, ["ID" => urlencode($arOrder["ID"])]);
				}

				$this->formatDate($arOrder, $this->orderDateFields2Convert, self::ACTIVE_DATE_FORMAT);
			}
			$arResult["ORDERS"] = $this->dbResult['ORDERS'];
		} else {
			$arResult["ORDERS"] = [];
		}

		return $arResult;
	}

	/**
	 * @param string $urlDetail
	 * @return void
	 */
	public function setUrlDetail(string $urlDetail): void
	{
		$this->urlToDetail = $urlDetail;
	}

	/**
	 * @param string $urlCancel
	 * @return void
	 */
	public function setUrlCancel(string $urlCancel): void{
		$this->urlToCancel = $urlCancel;
	}
}
