<?php

use Bitrix\Main;
use lib\Personal\Seller\SaleOrderList;
use lib\Personal\Seller\SaleOrderListFinished;
use lib\Personal\Seller\SaleOrderListClosed;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

class CSellerOrderList extends CBitrixComponent
{
	use lib\Personal\HasCheckAuthorized;

	/**
	 * @throws Main\SystemException
	 */
	public function executeComponent(): void
	{
		try {
			$this->setFrameMode(false);
			$this->setTitle();

			$isAuthorized = $this->checkAuthorized('Для просмотра списка заказов необходимо авторизоваться');
			if (!$isAuthorized) {
				return;
			}

			if (isset($_REQUEST["filter_finished"]) && $_REQUEST["filter_finished"] == "Y") {
				$saleOrderList = new SaleOrderListFinished();
				$filterType = 'FINISHED';
			} elseif (isset($_REQUEST["filter_closed"]) && $_REQUEST["filter_closed"] == "Y") {
				$saleOrderList = new SaleOrderListClosed();
				$filterType = 'CLOSED';
			} else {
				$saleOrderList = new SaleOrderList();
				$filterType = 'ORDERS';
			}

			$saleOrderList->setUrlDetail($this->arParams["PATH_TO_DETAIL"]);
			$saleOrderList->setUrlCancel($this->arParams["PATH_TO_CANCEL"]);
			$this->arResult = $saleOrderList->exec();

			$this->arResult['FILTER_TYPE'] = $filterType;
		} catch (Exception $e) {
			throw new Main\SystemException($e);
		}

		$this->includeComponentTemplate();
	}

	/**
	 * Function sets page title, if required
	 * @return void
	 */
	protected function setTitle(): void
	{
		global $APPLICATION;
		$APPLICATION->SetTitle('Заказы клиентов');
	}

}