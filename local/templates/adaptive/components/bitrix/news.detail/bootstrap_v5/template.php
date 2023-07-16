<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
?>
<main class="flex-shrink-0 mb-5"><div class="container">
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

		<?php if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
			<h1 class="layout__title"><?=$arResult["NAME"]?></h1>
		<?php endif;?>
		<div class="detail-page">

			<?php if($arResult["TIMESTAMP_X"] <> ''):?>
			<div class="detail-page__date">
				Опубликовано:  <?=CIBlockFormatProperties::DateFormat('d.m.Y', MakeTimeStamp($arResult["TIMESTAMP_X"])).' г.'?>
			</div>
			<?php endif?>

			<?php if(($arParams["DISPLAY_PICTURE"]!="N") && (is_array($arResult["DETAIL_PICTURE"]))):?>
				<div class="detail-page__image">
					<img
						src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
						alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
						title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
					/>
				</div>
			<?php endif?>
			<div class="detail-page__content text-content">


				<?php if($arResult["DETAIL_TEXT"] <> ''):?>
					<?echo $arResult["DETAIL_TEXT"];?>
				<?php else:?>
					<?echo $arResult["PREVIEW_TEXT"];?>
				<?php endif?>
			</div>
			<div class="detail-page__back">
				<a href="/news" class="btn btn-secondary btn-lg">Вернуться к списку новостей</a>
			</div>
		</div>
	</div>
</main>