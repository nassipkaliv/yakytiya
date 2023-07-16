<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/style.css");

?>

<?php
foreach ($arResult['ORDERS'] as $order)
{
?>
	<div class="row mx-0 sale-order-list-title-container">
		<h3 class="col mb-1 mt-1">Заказ <?=$order['ORDER']['ID']?> от <?=$order['ORDER']['DATE_INSERT_FORMATTED']?>,
			<?=count($order['BASKET_ITEMS']);?>
			<?php
			$count = count($order['BASKET_ITEMS']) ;
			if ($count == '1')
			{
				echo 'товар';
			}
			elseif ($count >= '2' && $count <= '4')
			{
				echo 'товара';
			}
			else
			{
				echo 'товаров';
			}
			?>
        	на сумму
			<?=$order['ORDER']['FORMATTED_PRICE']?>

			<?php if ($arResult['FILTER_TYPE'] === 'ORDERS') { ?>
				<span class="sale-order-list-status-restricted">
					В статусе  &laquo;<?=$order['ORDER']['FORMATTED_STATUS_NAME']?> &raquo;
				</span>
			<?php } ?>

		</h3>

		<div class="col-sm-auto">
			<?php if ($arResult['FILTER_TYPE'] === 'ORDERS') { ?>
				<?php
				if ($order['ORDER']['PAYED'] === 'Y')
				{
					?>
					<span class="sale-order-list-status-success">Оплачено</span>
					<?
				}
				else
				{
					?>
					<span class="sale-order-list-status-alert">Не оплачено</span>
					<?
				}
				?>
			<?php } ?>
			<?php if ($arResult['FILTER_TYPE'] !== 'ORDERS')  { ?>

				<?php if ($arResult['FILTER_TYPE'] === 'FINISHED') { ?>
				<span class="sale-order-list-accomplished-date">Заказ выполнен</span>
				<?php } ?>
				<?php if ($arResult['FILTER_TYPE'] === 'CLOSED') { ?>
					<span class="sale-order-list-accomplished-date canceled-order">Заказ отменен</span>
				<?php } ?>
				<span class="sale-order-list-accomplished-date"><?= $order['ORDER']['DATE_STATUS_FORMATTED'] ?></span>
			<?php } ?>
		</div>
	</div>
	<div class="row mx-0 mb-5">
		<div class="col pt-3 sale-order-list-inner-container">
			<div class="row pb-3 sale-order-list-inner-row">
				<div class="col-auto sale-order-list-about-container">
					<a class="g-font-size-15 sale-order-list-about-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>">Подробнее о заказе</a>
				</div>
				<div class="col"></div>

				<?php if ($arResult['FILTER_TYPE'] === 'ORDERS') { ?>
				<div class="col-auto sale-order-list-cancel-container">
					<a class="g-font-size-15 sale-order-list-cancel-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"])?>">Отменить заказ</a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
}
?>