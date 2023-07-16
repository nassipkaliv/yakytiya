<?

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/bootstrap_v4/style.css");
CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $code => $error)
	{
		if ($code !== $component::E_NOT_AUTHORIZED)
			ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		?>
		<div class="row">
			<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
				<div class="alert alert-danger"><?=$arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]?></div>
			</div>
			<? $authListGetParams = array(); ?>
			<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
				<?$APPLICATION->AuthForm('', false, false, 'N', false);?>
			</div>
		</div>
		<?
	}

}
else
{
	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach($arResult['ERRORS']['NONFATAL'] as $error)
		{
			ShowError($error);
		}
	}
	if (!count($arResult['ORDERS']))
	{
		if ($_REQUEST["filter_history"] == 'Y')
		{
			if ($_REQUEST["show_canceled"] == 'Y')
			{
				?>
				<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER')?></h3>
				<?
			}
			else
			{
				?>
				<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST')?></h3>
				<?
			}
		}
		else
		{
			?>
			<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST')?></h3>
			<?
		}
	}
	?>
	<div class="row mb-3">
		<div class="col">
			<?
			$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
			$clearFromLink = array("filter_history","filter_status","show_all", "show_canceled");

			if ($nothing || $_REQUEST["filter_history"] == 'N')
			{
				?>
				<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY")?></a>
				<?
			}
			if ($_REQUEST["filter_history"] == 'Y')
			{
				?>
				<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_CUR_ORDERS")?></a>
				<?
				if ($_REQUEST["show_canceled"] == 'Y')
				{
					?>
					<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY")?></a>
					<?
				}
				else
				{
					?>
					<a class="mr-4" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y&show_canceled=Y", $clearFromLink, false)?>"><?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_CANCELED")?></a>
					<?
				}
			}
			?>
		</div>
	</div>
	<?
	if (!count($arResult['ORDERS']))
	{
		?>
		<div class="row mb-3">
			<div class="col">
				<a href="<?=htmlspecialcharsbx($arParams['PATH_TO_CATALOG'])?>" class="mr-4"><?=Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG')?></a>
			</div>
		</div>
		<?
	}


	if ($_REQUEST["filter_history"] !== 'Y')
	{
		$paymentChangeData = array();
		$orderHeaderStatus = null;

		foreach ($arResult['ORDERS'] as $key => $order)
		{
			if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $arResult['SORT_TYPE'] == 'STATUS')
			{
				$orderHeaderStatus = $order['ORDER']['STATUS_ID'];

				?>
				<div class="row mb-3">
					<div class="col">
						<h2><?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])?>&raquo;</h2>
					</div>
				</div>
				<?
			}
			?>
			<div class="row mx-0 sale-order-list-title-container">
				<h3 class="col mb-1 mt-1">
					<?=Loc::getMessage('SPOL_TPL_ORDER')?>
					<?=Loc::getMessage('SPOL_TPL_NUMBER_SIGN').$order['ORDER']['ACCOUNT_NUMBER']?>
					<?=Loc::getMessage('SPOL_TPL_FROM_DATE')?>
					<?=$order['ORDER']['DATE_INSERT_FORMATED']?>,
					<?=count($order['BASKET_ITEMS']);?>
					<?
					$count = count($order['BASKET_ITEMS']) % 10;
					if ($count == '1')
					{
						echo Loc::getMessage('SPOL_TPL_GOOD');
					}
					elseif ($count >= '2' && $count <= '4')
					{
						echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
					}
					else
					{
						echo Loc::getMessage('SPOL_TPL_GOODS');
					}
					?>
					<?=Loc::getMessage('SPOL_TPL_SUMOF')?>
					<?=$order['ORDER']['FORMATED_PRICE']?>
				</h3>
				<div class="col-sm-auto">
					<?

					if ($order['ORDER']['PAYED'] === 'Y')
					{
						?>
						<span class="sale-order-list-status-success"><?=Loc::getMessage('SPOL_TPL_PAID')?></span>
						<?
					}
					else
					{
						?>
						<span class="sale-order-list-status-alert"><?=Loc::getMessage('SPOL_TPL_NOTPAID')?></span>
						<?
					}
					?>
				</div>
			</div>
			<div class="row mx-0 mb-5">
				<div class="col pt-3 sale-order-list-inner-container">
						<div class="row pb-3 sale-order-list-inner-row">
							<div class="col-auto sale-order-list-about-container">
								<a class="g-font-size-15 sale-order-list-about-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>"><?=Loc::getMessage('SPOL_TPL_MORE_ON_ORDER')?></a>
							</div>
							<div class="col"></div>

							<?
							if ($order['ORDER']['CAN_CANCEL'] !== 'N')
							{
								?>
								<div class="col-auto sale-order-list-cancel-container">
									<a class="g-font-size-15 sale-order-list-cancel-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"])?>"><?=Loc::getMessage('SPOL_TPL_CANCEL_ORDER')?></a>
								</div>
								<?
							}
							?>
						</div>
					</div>
				</div>
			<?
		}
	}
	else
	{
		$orderHeaderStatus = null;

		if ($_REQUEST["show_canceled"] === 'Y' && count($arResult['ORDERS']))
		{
			?>
			<div class="row mb-3">
				<div class="col">
					<h2><?= Loc::getMessage('SPOL_TPL_ORDERS_CANCELED_HEADER') ?></h2>
				</div>
			</div>
			<?
		}

		foreach ($arResult['ORDERS'] as $key => $order)
		{
			if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $_REQUEST["show_canceled"] !== 'Y')
			{
				$orderHeaderStatus = $order['ORDER']['STATUS_ID'];
				?>
				<h2 class="sale-order-title">
					<?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])?>&raquo;
				</h2>
				<?
			}
			?>
			<div class="row sale-order-list-accomplished-title-container">
				<h3 class="g-font-size-20 mb-1 mt-1 col-sm">
					<?= Loc::getMessage('SPOL_TPL_ORDER') ?>
					<?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') ?>
					<?= htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER'])?>
					<?= Loc::getMessage('SPOL_TPL_FROM_DATE') ?>
					<span class="text-nowrap"><?= $order['ORDER']['DATE_INSERT'] ?>,</span>
					<?= count($order['BASKET_ITEMS']); ?>
					<?
					$count = mb_substr(count($order['BASKET_ITEMS']), -1);
					if ($count == '1')
					{
						echo Loc::getMessage('SPOL_TPL_GOOD');
					}
					elseif ($count >= '2' || $count <= '4')
					{
						echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
					}
					else
					{
						echo Loc::getMessage('SPOL_TPL_GOODS');
					}
					?>
					<?= Loc::getMessage('SPOL_TPL_SUMOF') ?>
					<span class="text-nowrap"><?= $order['ORDER']['FORMATED_PRICE'] ?></span>
				</h3>
				<div class="col-sm-auto">
					<?
					if ($_REQUEST["show_canceled"] !== 'Y')
					{
						?>
						<span class="sale-order-list-accomplished-date">
									<?= Loc::getMessage('SPOL_TPL_ORDER_FINISHED')?>
								</span>
						<?
					}
					else
					{
						?>
						<span class="sale-order-list-accomplished-date canceled-order">
									<?= Loc::getMessage('SPOL_TPL_ORDER_CANCELED')?>
								</span>
						<?
					}
					?>
					<span class="sale-order-list-accomplished-date"><?= $order['ORDER']['DATE_STATUS_FORMATED'] ?></span>
				</div>
			</div>
			<div class="row mb-5">
				<div class="col pt-3 sale-order-list-inner-container">
					<div class="row pb-3 sale-order-list-inner-row">
						<div class="col-auto col-auto sale-order-list-about-container">
							<a class="g-font-size-15 sale-order-list-about-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>"><?=Loc::getMessage('SPOL_TPL_MORE_ON_ORDER')?></a>
						</div>
					</div>
				</div>
			</div>
			<?
		}
	}

	echo $arResult["NAV_STRING"];
}
?>
