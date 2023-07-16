<?php
namespace lib\Personal\Seller;

use lib\Personal\BaseSaleOrderList ,
	lib\Personal\ContractBaseSaleOrderList;
class SaleOrderListFinished extends BaseSaleOrderList implements ContractBaseSaleOrderList
{
	protected array $filterSeller =
		[
			//'USER_ID' => '1',
			'LID' => 's1',
			0 => [
				'@STATUS_ID' => [
					0 => 'F',
				]
			],
		];

	protected array $selectSeller =
		[
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
		];

	public function __construct()
	{
		$this->setFilter($this->filterSeller);
		$this->setSelect($this->selectSeller);
	}

	public function setFilter($arFilter): void
	{
		$this->filter = $arFilter;
	}

	public function setSelect($arSelect): void
	{
		$this->select = $arSelect;
	}
}