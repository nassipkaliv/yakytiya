<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogTopComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
?>
	<div class="homepage__slide">
		<div class="homepage__slide-inner">
			<h2 class="container-fluid homepage__h2">
				Лучшие предложения
			</h2>
			<?
			\CU_MainPage_GoodsBlock::printDoubleSliderBlock($arResult['RAW_ITEMS'], 'popular');
			?>
		</div>
	</div>
<?php