<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @var array $arResult
 * @var array $arParam
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
?>

<div class="d-flex justify-content-end mt-5">
	<nav aria-label="Постраничная навигация">
		<?php
		$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
		$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
		?>
		<ul class="pagination">
			<?php

			if ($arResult["NavPageNomer"] > 1):
				if($arResult["bSavePage"]):	?>
					<li class="page-item">
						<a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
							<svg class="uicon-pagination_arrow" width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M11 1L1 11L11 21" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</a>
					</li>
				<?php
				else:
					if ($arResult["NavPageNomer"] > 2):	?>
						<li class="page-item">
							<span class="page-link">
								<svg class="uicon-pagination_arrow" width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11 1L1 11L11 21" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</span>
						</li>
					<?php
					else: ?>
						<li class="page-item">
							<a class="page-link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
								<svg class="uicon-pagination_arrow" width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11 1L1 11L11 21" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</a>
						</li><?php
					endif;
				endif;
			endif;

			if ($arResult["NavPageNomer"] > 1):
				if ($arResult["nStartPage"] > 1):
					if($arResult["bSavePage"]):?>
						<li class="page-item">
							<a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
						</li>
					<?php
					else:?>
						<li class="page-item">
							<a class="page-link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
						</li>
					<?php
					endif;
					if ($arResult["nStartPage"] > 2):?>
						<li class="page-item">
							<a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nStartPage"] / 2)?>">...</a>
						</li><?php
					endif;
				endif;
			endif;

			do
			{
				if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
					<li class="page-item active">
						<span class="page-link"><?=$arResult["nStartPage"]?></span>
					</li>
				<?php
				elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
					<li class="page-item">
						<a class="page-link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
					</li><?php
				else:?>
					<li class="page-item">
						<a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>">
							<?=$arResult["nStartPage"]?>
						</a>
					</li>
				<?php endif;
				$arResult["nStartPage"]++;
			}

			while($arResult["nStartPage"] <= $arResult["nEndPage"]);

			if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
				if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
					if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):?>
						<li class="page-item">
							<a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?>">...</a>
						</li><?php
					endif;
					?>
					<li class="page-item">
						<a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
					</li><?php
				endif;
			endif;

			if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
				<li class="page-item">
					<a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
						<svg class="uicon-pagination_arrow" width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 1L11 11L1 21" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</li>
			<?php
			endif;

			?>
		</ul>
	</nav>
</div>