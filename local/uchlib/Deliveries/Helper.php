<?php
use Bitrix\Sale\Internals\DiscountTable;

class CU_Deliveries_Helper
{
	public static function test() {
		echo '111111';
	}

	public static function printDeliveries($publisherId)
	{
		if ($publisherId) {
			$delivery = '';
			$arSort = ['ID' => 'DESC'];
			$arFilter = ['IBLOCK_ID' => 5, 'ID' => $publisherId];
			$arSelect = array('ID', 'PROPERTY_DELIVERY');

			$res = CIBlockElement::getList($arSort, $arFilter, false, [], $arSelect);
			$deliveries = [];
			if ($row = $res->fetch()) {
				$deliveries = $row['PROPERTY_DELIVERY_VALUE'];
			}

			if (!array_filter($deliveries)) {
				return;
			}

			echo "
			<style>
			ul.deliveries {
			  list-style: none;
			}
			
			ul.deliveries li:before {
			  content: \"✓\";
			}
			</style>
		";
			echo '<h3>Доставка</h3>';
			echo '<ul class="deliveries">';
			foreach ($deliveries as $delivery) {
				echo '<li>' . $delivery . '</li>';
			}
			echo '</ul>';
		}
	}

	public static function getDeliveries(): array
	{
		$arDeliveries = [
			'Стоимость доставки устанавливается Продавцом и зависит от
тарифов Почты России. Точную информацию о стоимости доставки
Вы можете узнать при оформлении заказа. Доставка по г.Якутску
по договоренности.
',
			'Доставка по городу Якутску бесплатно.

Доставка в другие города и улусы республики осуществляется Почтой России.

ДОСТАВКА ПО РОССИИ, страны СНГ и по миру осуществляется Почтой России и компанией DPD.

За пределы РФ в страны Таможенного союза ЕАЭС (Казахстан, Беларусь Армения, Киргизия) – доставка DPD, остальные страны — Почта России
'
		];

		return $arDeliveries;
	}
}