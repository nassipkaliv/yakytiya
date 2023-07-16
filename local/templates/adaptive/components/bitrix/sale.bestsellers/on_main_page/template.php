<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);

?>
<div class="homepage__slide">
	<div class="homepage__slide-inner">
		<h2 class="container-fluid homepage__h2">
			Популярные товары
		</h2>
		<?
		\CU_MainPage_GoodsBlock::printDoubleSliderBlock($arResult['ITEMS']);
		?>
	</div>
</div>

<?php