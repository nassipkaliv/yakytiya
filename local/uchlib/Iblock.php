<?php

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\Entity\Query;
use Bitrix\Main\Loader;

class CU_Iblock
{
	public const ERR_NOT_FOUND = 0;        //инфоблок не найден
	public const ERR_NO_MODULE = -1;       //модуль 'iblock' не подключен
	public const ERR_CODE_EMPTY = -2;      //длина символьного кода нулевая
	public const ERR_CODE_DUPLICATED = -3; //в базе несколько инфоблоков с одинаковым кодом

	/**
	 * Возвращает ID инфоблока по символьному коду
	 * @param $code - символьный код инфоблока
	 * @return int - положительное значение - это ID инфоблока, иначе - ошибка
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Bitrix\Main\SystemException
	 */
	public static function getIdByCode($code): int
	{
		static $localCache = null;
		$code = trim($code);

		if ($localCache !== null && array_key_exists($code, $localCache)) {
			return $localCache[$code];
		}

		if (empty($code)) {
			return $localCache[$code] = self::ERR_CODE_EMPTY;
		}

		$arIbData = self::getIblockData();

		$arIDs = [];
		foreach ($arIbData as $ibDatum) {
			if ($ibDatum['CODE'] === $code) {
				$arIDs[] = $ibDatum['ID'];
			}
		}

		if (count($arIDs) > 1) {
			return $localCache[$code] = self::ERR_CODE_DUPLICATED;
		}

		if (count($arIDs) === 1) {
			return $localCache[$code] = $arIDs[0];
		}

		return $localCache[$code] = self::ERR_NOT_FOUND;
	}


	/**
	 * Получает поля ID, CODE, IBLOCK_TYPE_ID всех инфоблоков
	 * @return array струтура: [ID][Название поля] = значение
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Bitrix\Main\ObjectPropertyException
	 * @throws \Bitrix\Main\SystemException
	 */
	private static function getIblockData()
	{
		static $localCache = null;

		if ($localCache !== null) {
			return $localCache;
		}

		if (!Loader::includeModule('iblock')) {
			return self::ERR_NO_MODULE;
		}

		$arIbData = [];


		$cache = Cache::createInstance();
		if ($cache->initCache(60*5, __METHOD__, __CLASS__)) {
			$arIbData = $cache->getVars();
		}

		if (empty($arIbData)) {
			static $arSelect = ['ID', 'CODE', 'IBLOCK_TYPE_ID'];
			$entity = IblockTable::getEntity();
			$query = new Query($entity);
			$query
				->setSelect($arSelect)
				->setOrder(['ID' => 'ASC']);
			$res = $query->exec();

			while ($arFields = $res->fetch()) {
				foreach ($arSelect as $field) {
					$arIbData[$arFields['ID']][$field] = $arFields[$field];
				}
			}

			if ($cache->startDataCache()) {
				$cache->endDataCache($arIbData);
			}
		}

		return $localCache = $arIbData;
	}
}