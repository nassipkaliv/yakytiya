<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arParams["MAIN_CHAIN_NAME"] <> '')
{
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}

$this->addExternalCss("/bitrix/css/main/font-awesome.css");
$theme = Bitrix\Main\Config\Option::get("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);

$availablePages = array();

	//Настройки производителя
	$availablePages[] = [
		"path" => $arResult['PATH_TO_PRIVATE'],
		"name" => 'Профиль компании',
		"icon" => '<i class="fa fa-user-secret"></i>'
	];

	//Заказы
	$availablePages[] = [
		"path" => $arResult['PATH_TO_ORDERS'],
		"name" => 'Заказы',
		"icon" => '<i class="fa fa-calculator"></i>'
	];
?>
<div class="row">
	<? foreach ($availablePages as $blockElement)
	{
		?>
		<div class="col-lg-3 col-md-4 col-6">
			<div class="sale-personal-section-index-block bx-<?=$theme?>">
				<a class="sale-personal-section-index-block-link" href="<?=htmlspecialcharsbx($blockElement['path'])?>">
					<span class="sale-personal-section-index-block-ico">
						<?=$blockElement['icon']?>
					</span>
					<h2 class="sale-personal-section-index-block-name">
						<?=htmlspecialcharsbx($blockElement['name'])?>
					</h2>
				</a>
			</div>
		</div>
		<?
	}
	?>
</div>





