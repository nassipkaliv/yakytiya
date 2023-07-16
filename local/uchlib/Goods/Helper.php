<?php
use Bitrix\Sale\Internals\DiscountTable;
use Bitrix\Sale;

class CU_Goods_Helper
{
	public static function getIds_novelties($limit, $iblockId)
	{
		$elements = [];
		if (\Bitrix\Main\Loader::includeModule('iblock')) {

			$arSort = ['created' => 'DESC', 'ID' => 'DESC'];
			$arFilter = ['ACTIVE' => 'Y', 'IBLOCK_ID' => $iblockId];
			$arSelect = array('ID', 'NAME');

			$res = CIBlockElement::getList($arSort, $arFilter, false, ['nTopCount' => $limit], $arSelect);
			while ($row = $res->fetch()) {
				$elements[] = $row['ID'];
			}
		}

		return $elements;
	}

	public static function getIds_discounted($limit)
	{
		//это новый вариант, когда скидки просчитываются по всем товарам.
		//идея навеяна https://dev.1c-bitrix.ru/support/forum/forum6/topic108539/
		//внутри кэшируется с учётом даты последней мофикации скидок.
		$discountedElementsIds = self::whatGoodsWithDiscountsCached($limit);
		return $discountedElementsIds;

		//это первоначальный вариант - когда парсил таблицу. Не правильно, потому, что обрабатывает лишь самый простой вариант.
		//чуть сложнее самого простого - не возьмёт
		//а через конструктор в таблицу легко можно понаписать много всего.
		//$discountedElementsIds = \CU_Goods_Helper::pasreDiscountsTable($limit);
		//return $discountedElementsIds;
	}

	/** кэширующая обёртка. в соли использует дату последней модификации скидок - чтобы поддерживать актуальность
	 * @param $limit
	 * @return array
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Bitrix\Main\LoaderException
	 * @throws \Bitrix\Main\ObjectPropertyException
	 * @throws \Bitrix\Main\SystemException
	 */
	public static function whatGoodsWithDiscountsCached($limit)
	{
		$cacheTime = 60 * 60 * 24 * 3;    //3 дня
		$cacheDir = __METHOD__;

		$discountsQuery = \Bitrix\Sale\Internals\DiscountTable::getList([
			'filter' => [
				"LID" => "s1",
				'ACTIVE' => 'Y'
			],
			'order' => ["TIMESTAMP_X" => "DESC"],
			'select' => [
				"*"
			]
		]);
		$lastDiscountElement = $discountsQuery->fetch();

		$lastDiscountModificationSalt = (string)$lastDiscountElement['TIMESTAMP_X'];
		$cacheID = __METHOD__ . $lastDiscountModificationSalt;  //делаем зависимым от времени модификации

		$cache = new CPHPCache();
		if ($cache->InitCache($cacheTime, $cacheID, $cacheDir)) { // Проверка кэша
			$discountedElementsIds = $cache->GetVars();
		} else {
			$cache->StartDataCache();

			$discountedElementsIds = self::whatGoodsWithDiscounts($limit);

			$cache->EndDataCache($discountedElementsIds);
		}

		return $discountedElementsIds;
	}

	/**
	 * @param $limit
	 * @return array
	 * @throws \Bitrix\Main\LoaderException
	 */
	private static function whatGoodsWithDiscounts($limit)
	{
		$allGoodsIds = [];
		if (\Bitrix\Main\Loader::includeModule('iblock')) {
			//все товары
			$arSort = ['created' => 'DESC', 'ID' => 'DESC'];
			$arFilter = ['ACTIVE' => 'Y', 'IBLOCK_ID' => 6];
			$arSelect = ['ID'];

			$saleGroups = array(2); //все. и не авторизованные тоже
			$prices = array(1); //а всего один тип цены

			$res = CIBlockElement::getList($arSort, $arFilter, false, [], $arSelect);
			while ($row = $res->fetch()) {
				//по всем товарам пробуем все скидки. и сравниваем цены без скидок и со скидками

				$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
					$row['ID'],
					$saleGroups,
					"N",
					$prices,
					's1'
				);

				if (is_array($arDiscounts) && count($arDiscounts) > 0) {
					$allGoodsIds[] = $row['ID'];
					if (count($allGoodsIds) >= $limit) {
						return $allGoodsIds;
					}
				}
			}
		}
		return $allGoodsIds;
	}

	/** старый вариант. переключиться на него если будет слишком много товаров*скидок и кэширование не спасёт
	 * @param $limit
	 * @return array
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Bitrix\Main\ObjectPropertyException
	 * @throws \Bitrix\Main\SystemException
	 */
	private static function pasreDiscountsTable($limit)
	{
		$discountsQuery = \Bitrix\Sale\Internals\DiscountTable::getList([
			'filter' => [
				"LID" => "s1",
				'ACTIVE' => 'Y'
			],
			'select' => [
				"*"
			]
		]);
		$discountedElementsIds = [];

		$counter = 0;
		while ($data = $discountsQuery->fetch()) {
			if ($data['ACTIONS_LIST']['CLASS_ID'] == 'CondGroup') {
				foreach ($data['ACTIONS_LIST']['CHILDREN'] as $child) {
					if ($child['CLASS_ID'] == 'ActSaleBsktGrp') {
						foreach ($child['CHILDREN'] as $grandChild) {
							if ($grandChild['CLASS_ID'] == 'CondIBElement') {
								foreach ($grandChild['DATA']['value'] as $elements) {
									$discountedElementsIds[] = $elements;
									$counter++;
									if ($counter > $limit) {
										break;
									}
								}
							}
						}
					}
				}
			}
		}
		return $discountedElementsIds;
	}

	/** поскольку требования допускают *и* товары *и* товарные предложения, то нам оба варианта учитывать.
	 * а sku по умолчанию идёт как айдишник *базового* товара. а API работают с айдишниками *sku*.
	 * этот метод добывает правильный айдишник
	 * @return void
	 */
	public static function getProductOrSkuId($arResult)
	{
		if (empty($arResult['OFFERS'])) {
			//обычный товар
			return $arResult['ID'];
		} else {
			//товарное предложение. узнаем какое именно
			$selectedOfferId = $arResult['OFFER_ID_SELECTED'];
			return $arResult['OFFERS'][$selectedOfferId]['ID'];
		}
	}

	public static function IsProductInActualBasket($productId)
	{
		$fuserId = \CSaleBasket::GetBasketUserID(false);
		$basketRes = Sale\Internals\BasketTable::getList(array(
			'filter' => array(
				'ORDER_ID' => null,
				'PRODUCT_ID' => $productId,
				'CAN_BUY' => 'Y',
				'DELAY' => 'N',
				'FUSER_ID' => $fuserId
			)
		));
		if ($item = $basketRes->fetch()) {
			return true;
		}
		return false;
	}

	/** - был ли куплен товар текущим пользователем
	 * @param $productId
	 * @return bool
	 */
	public static function wasProductBought($productId)
	{
		$ordersOfUserWithProduct = [];
		$userId = $GLOBALS['USER']->GetId();
		$fuserId = \CSaleBasket::GetBasketUserID(false);
		$basketRes = Sale\Internals\BasketTable::getList(array(
			'filter' => array(
				'!ORDER_ID' => null,
				'PRODUCT_ID' => $productId
			)
		));

		$ordersIds = [];
		while ($item = $basketRes->fetch()) {
			$ordersIds[] =  $item['ORDER_ID'];
		}
		$userId = $GLOBALS['USER']->GetId();

		$dbRes = \Bitrix\Sale\Order::getList([
			'select' => ['ID'],
			'filter' => [
				'STATUS_ID' => 'F',
				'PAYED' => 'Y',
				'CANCELED' => 'N',
				"USER_ID" => $userId,
				'ID' => $ordersIds
			],
		]);
		if ($order = $dbRes->fetch()) {
			return true;
		}

		return false;
	}

	/** не используется. старая реализация wasProductBought - когда в условии было лишь что куплен - не было статуса заказа
	 * @param $productId
	 * @return bool
	 */
	private static function _wasProductBoughtBybasket($productId) {
		$userId = $GLOBALS['USER']->GetId();
		$x=0;
		$dbBasketItems = \CSaleBasket::GetList(
			array("ID" => "ASC"),
			array(
				"!ORDER_ID" => NULL,
				'PRODUCT_ID' => $productId,
				'USER_ID' => $userId,
			),
			false,
			false,
			array("PRODUCT_ID", "USER_ID", "FUSER_ID", "ORDER_ID")
		);

		if ($arBasketItem = $dbBasketItems->Fetch()) {
			return true;
		} else {
			return false;
		}
	}


	public static function printProductDelay($productId)
	{
		?>
		<style>
			.delay {
				cursor:pointer;
			}
		</style>
		<?php
		$isDelayed = self::isDelayed($productId);
		if ($isDelayed) {
			$clsWhite = 'hidden';
			$clsRed = '';
		} else {
			$clsWhite = '';
			$clsRed = 'hidden';
		}
		?>
		<div class="delay <?=$clsWhite?>" onclick="delay(<?=$productId?>)">♡</div>
		<div class="delayed <?=$clsRed?>" >❤️</div>
		<?php
		if (!$isDelayed) {
			self::printDelaySuccessModal();
		}
	}

	private static function printDelaySuccessModal()
	{
		?>
		<br>
		<div class="modal" id="delyaedModalId" tabindex="-1" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>

					<div class="modal-body">
						<p>Товар успешно отложен</p>
					</div>

				</div>
			</div>
		</div>

		<?php
	}

	public static function printWrongSellerModal()
	{
		?>
		<br>
		<div class="modal" id="wrongSellerModalId" tabindex="-1" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>

					<div class="modal-body">
						<p>Товар добавлен в избранное, Вы выбрали товар другого производителя, для оформления заказа завершите текущий заказ</p>
					</div>

				</div>
			</div>
		</div>

		<?php
	}

	private static function isDelayed($productId)
	{
		$fuserId = \CSaleBasket::GetBasketUserID(false);
		CModule::IncludeModule('sale');
		$res = CSaleBasket::GetList(
			array(),
			array(
				"FUSER_ID" => $fuserId,
				"LID" => SITE_ID,
				"ORDER_ID" => "NULL",
				"PRODUCT_ID" => $productId,
				'DELAY' => 'Y',
				'CAN_BUY' => 'Y'
			),
			false,
			false,
			array("ID")
		);
		if ($el = $res->Fetch()) {
			return true;
		}
		return false;
	}

	public static function delayProduct($productId)
	{
		CModule::IncludeModule('sale');

		$addResult = \Bitrix\Catalog\Product\Basket::addProduct([
			'PRODUCT_ID' => $productId,
			'QUANTITY' => 1,
			'DELAY' => 'Y'
		]);
		$addToBasketSuccess = $addResult->isSuccess();

		return $addToBasketSuccess;
	}

	public static function printSeller($productId)
	{
		if ($productId) {
			$producer = self::getProductProducerData($productId);
			if ($producer['SRC']) {
			?>
				<h3>Производитель</h3>
				<a href="/seller/e<?=$producer['ID']?>/"><img src="<?=$producer['SRC']?>"></a>
			<?php
			}
		}
	}

	/** по айдишнику товара добывает данные о его производителе - унифицированно обычный ли товар или торговое предложение
	 *
	 * @param $productId
	 * @return array|null
	 * @throws \Bitrix\Main\LoaderException
	 */
	public static function getProductProducerData($productId)
	{
		if (\Bitrix\Main\Loader::includeModule('iblock')) {
			//по id товара - кто производитель
			$sellerByProduct = self::getProductProducerDataForProduct($productId);
			if ($sellerByProduct) {
				return $sellerByProduct;
			} else {
				$sellerBySku = self::getProductProducerDataForSku($productId);
				return $sellerBySku;
			}
		}

		return [];
	}

	/** данные о производителе товара для обычного товара
	 * @param $productId
	 * @return array|void|null
	 */
	private static function getProductProducerDataForProduct($productId)
	{
		$arSort = ['created' => 'DESC', 'ID' => 'DESC'];
		$arFilter = [
			'ACTIVE' => 'Y',
			'IBLOCK_ID' => 6,
			'ID' => $productId
		];
		$arSelect = array('ID','IBLOCK_ID','PROPERTY_PUBLISHER');
		$res = CIBlockElement::getList($arSort, $arFilter, false, ['nTopCount' => 1], $arSelect);
		if ($row = $res->fetch()) {
			$publisherId = $row['PROPERTY_PUBLISHER_VALUE'];
			if (!$publisherId) {
				return [];  //не выставлен производитель. по хорошему - не может быть. но может старый товар.
			}
			//производителя нашли. что про него известно?
			return \CU_Seller_Helper::getSellerData($publisherId);
		}
	}

	/** данные о производителе товара для торгового предложения
	 * @param $productId
	 * @return array|void|null
	 */
	private static function getProductProducerDataForSku($productId)
	{
		$arSort = ['created' => 'DESC', 'ID' => 'DESC'];
		$arFilter = [
			'ACTIVE' => 'Y',
			'IBLOCK_ID' => 9,
			'ID' => $productId
		];
		$arSelect = array('ID','IBLOCK_ID','PROPERTY_CML2_LINK');
		$res = CIBlockElement::getList($arSort, $arFilter, false, ['nTopCount' => 1], $arSelect);
		if ($row = $res->fetch()) {
			$baseProductId = $row['PROPERTY_CML2_LINK_VALUE'];
			if (!$baseProductId) {
				return [];  //нет связки с базовым товаром. по хорошему - не может быть. но может старый товар.
			}
			//производителя нашли. что про него известно?
			return self::getProductProducerDataForProduct($baseProductId);
		}
	}

	public static function isByPreorder($arProperties)
	{
		return $arProperties['IS_PREORDER']['VALUE'] == 1;
	}

	public static function isFreeDelivery($productId)
	{
		//todo
		return false;
	}

	/** для масштабирвоания картинок. внутри вызывает битриксовую функцию, внутри себя использующую файловое кэширование.
	 * https://dev.1c-bitrix.ru/api_help/main/reference/cfile/resizeimageget.php
	 * Метод уменьшает картинку и размещает уменьшенную копию в папку /upload/resize_cache/путь.
	 * Один раз уменьшив изображение получаем физический файл, который позволяет при последующих обращениях не проводить
	 * операции по уменьшению изображения. При следующем вызове метод вернет путь к уменьшенному файлу
	 * @param $productUnscaledFileId
	 * @param $whereTo //допустимы: novelties (главная блок новинок), slider_row (главная: блок попоулярных товаров; блок лучших предложений)
	 * @param $dim
	 * @return mixed
	 */
	public static function getProductScaledImage($productUnscaledFileId, $whereTo = false, $dim = false)
	{
		//если файла нет
		if (!$productUnscaledFileId) {
			if ($whereTo == 'novelties') {
				return '/images/no_product_410_411.png';
			} else {
				return '/images/no_product_195_195.png';
			}
		}

		//сейчас масштабируем к точным размером методом точной обрезки. с другими методами большие проблемы.
		$resizeType = BX_RESIZE_IMAGE_EXACT;
		if (!$dim) {
			if ($whereTo == 'novelties') {  //главная блок новинок
				$dim = array('width'=>410, 'height'=>411);
			} elseif ($whereTo == 'slider_row') {
				$dim = array('width'=>195, 'height'=>195);
			} else {
				$dim = array('width'=>410, 'height'=>411);  //default
			}
		}

		$file = CFile::ResizeImageGet($productUnscaledFileId, $dim, $resizeType, true, false, true);
		return $file['src'];
	}

	public static function countActualGoods()
	{
		$items = [];
		$fuserId = \CSaleBasket::GetBasketUserID(false);
		$basketRes = Sale\Internals\BasketTable::getList(array(
			'filter' => array(
				'ORDER_ID' => null,
				'FUSER_ID' => $fuserId,
				'DELAY' => 'N',
				'CAN_BUY' => 'Y'
			)
		));

		while ($item = $basketRes->fetch()) {
			$items[] = $item;
		}
		return count($items);
	}

	public static function countDelayedGoods()
	{
		$items = [];
		$fuserId = \CSaleBasket::GetBasketUserID(false);
		$basketRes = Sale\Internals\BasketTable::getList(array(
			'filter' => array(
				'ORDER_ID' => null,
				'FUSER_ID' => $fuserId,
				'DELAY' => 'Y',
				'CAN_BUY' => 'Y'
			)
		));

		while ($item = $basketRes->fetch()) {
			$items[] = $item;
		}
		return count($items);
	}
}