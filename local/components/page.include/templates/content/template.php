<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

/**
 * @var array $arResult
 * @var array $APPLICATION
 * @var array $arParams
 * @var CBitrixComponentTemplate $this
 */
?>
<main class="flex-shrink-0 mb-5">
	<div class="container">
		<?php
		if ($arParams["CHAIN_NAME"] <> '') {
			{
				$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["CHAIN_NAME"]));
			}
			$APPLICATION->IncludeComponent(
				"bitrix:breadcrumb",
				"bootstrap_v5",
				[
					"START_FROM" => "0",
					"PATH" => "",
					"SITE_ID" => "-"
				],
				false,
				array('HIDE_ICONS' => 'Y')
			);
		}

		?>
		<?php
		if ($APPLICATION->GetTitle() <> ''): ?>
			<div class="detail-page__date">
				<h1 class="layout__title"><?= $APPLICATION->GetTitle() ?></h1>
			</div>
		<?php
		endif ?>
		<div class="text-content">
			<?php
			$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => SITE_DIR . $arParams['INCLUDE_PATCH'],
				),
				false
			);
			?>
		</div>
	</div>
</main>
