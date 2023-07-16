<?php
namespace lib\Personal;

interface ContractBaseSaleOrderList
{
	public function setFilter(array $arFilter): void;

	public function setSelect(array $arSelect): void;
}