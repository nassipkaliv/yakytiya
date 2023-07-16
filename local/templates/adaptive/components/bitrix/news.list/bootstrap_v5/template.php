<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

?>
<main class="flex-shrink-0 mb-5">
	<h1 class="layout__title-bg layout__title-bg_news">
		<div class="container">
			Новости
		</div>
	</h1>
	<div class="container">
		<?php
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
		); ?>
		<div class="news-list">

			<div class="row">
				<?php
				foreach ($arResult["ITEMS"] as $arItem): ?>
					<div class="news-list__el">
						<?php if (is_array($arItem["PREVIEW_PICTURE"])): ?>
						<a class="news-list__el-image" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
							<img
								src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
								alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
								title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
							/>
						</a>
						<?php endif;?>
						<div class="news-list__el-body">
							<h2>
								<a class="news-list__el-title" href="<?php echo $arItem["DETAIL_PAGE_URL"] ?>">
									<?php echo $arItem["NAME"] ?></a>
							</h2>
							<?php if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
								<?php echo $arItem["PREVIEW_TEXT"]; ?>
							<?php endif; ?>
							<a class="btn btn-lg btn-secondary" href="<?php echo $arItem["DETAIL_PAGE_URL"] ?>">Подробнее</a>
						</div>
					</div>
				<?php
				endforeach; ?>
			</div>
		</div>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?>
		<?endif;?>
	</div>

</main>