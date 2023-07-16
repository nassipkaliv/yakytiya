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
/** @var array $skuTemplate */
/** @var array $templateData */
$this->setFrameMode(true);

if (!empty($arResult['ITEMS']))
{
	$arResult['SKU_PROPS'] = reset($arResult['SKU_PROPS']);
	$skuTemplate = array();
	if (!empty($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as $arProp)
		{
			$propId = $arProp['ID'];
			$skuTemplate[$propId] = array(
				'SCROLL' => array(
					'START' => '',
					'FINISH' => '',
				),
				'FULL' => array(
					'START' => '',
					'FINISH' => '',
				),
				'ITEMS' => array()
			);
			$templateRow = '';
			if ('TEXT' == $arProp['SHOW_MODE'])
			{
				$skuTemplate[$propId]['SCROLL']['START'] = '<div class="bx_item_detail_size full" id="#ITEM#_prop_'.$propId.'_cont">'.
					'<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($arProp['NAME']).'</span>'.
					'<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';;
				$skuTemplate[$propId]['SCROLL']['FINISH'] = '</ul></div>'.
					'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style=""></div>'.
					'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style=""></div>'.
					'</div></div>';

				$skuTemplate[$propId]['FULL']['START'] = '<div class="bx_item_detail_size" id="#ITEM#_prop_'.$propId.'_cont">'.
					'<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($arProp['NAME']).'</span>'.
					'<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';;
				$skuTemplate[$propId]['FULL']['FINISH'] = '</ul></div>'.
					'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style="display: none;"></div>'.
					'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style="display: none;"></div>'.
					'</div></div>';
				foreach ($arProp['VALUES'] as $value)
				{
					$value['NAME'] = htmlspecialcharsbx($value['NAME']);
					$skuTemplate[$propId]['ITEMS'][$value['ID']] = '<li data-treevalue="'.$propId.'_'.$value['ID'].
						'" data-onevalue="'.$value['ID'].'" style="width: #WIDTH#;" title="'.$value['NAME'].'"><i></i><span class="cnt">'.$value['NAME'].'</span></li>';
				}
				unset($value);
			}
			elseif ('PICT' == $arProp['SHOW_MODE'])
			{
				$skuTemplate[$propId]['SCROLL']['START'] = '<div class="bx_item_detail_scu full" id="#ITEM#_prop_'.$propId.'_cont">'.
					'<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($arProp['NAME']).'</span>'.
					'<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';
				$skuTemplate[$propId]['SCROLL']['FINISH'] = '</ul></div>'.
					'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style=""></div>'.
					'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style=""></div>'.
					'</div></div>';

				$skuTemplate[$propId]['FULL']['START'] = '<div class="bx_item_detail_scu" id="#ITEM#_prop_'.$propId.'_cont">'.
					'<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($arProp['NAME']).'</span>'.
					'<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';
				$skuTemplate[$propId]['FULL']['FINISH'] = '</ul></div>'.
					'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style="display: none;"></div>'.
					'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style="display: none;"></div>'.
					'</div></div>';
				foreach ($arProp['VALUES'] as $value)
				{
					$value['NAME'] = htmlspecialcharsbx($value['NAME']);
					$skuTemplate[$propId]['ITEMS'][$value['ID']] = '<li data-treevalue="'.$propId.'_'.$value['ID'].
						'" data-onevalue="'.$value['ID'].'" style="width: #WIDTH#; padding-top: #WIDTH#;"><i title="'.$value['NAME'].'"></i>'.
						'<span class="cnt"><span class="cnt_item" style="background-image:url(\''.$value['PICT']['SRC'].'\');" title="'.$value['NAME'].'"></span></span></li>';
				}
				unset($value);
			}
		}
		unset($templateRow, $arProp);
	}
}

$intRowsCount = count($arResult['ITEMS']);
$strRand = $this->randString();
$strContID = 'cat_top_cont_'.$strRand;

?>

<div class="homepage__slide homepage__slide_novelties">
	<div class="homepage__slide-inner">
		<h2 class="container-fluid homepage__h2">
			Новинки
		</h2>
		<!-- Swiper -->
		<div class="swiper swiper-novelties js-swiper-novelties">
			<div class="swiper-wrapper">
				<?
				foreach ($arResult['RAW_ITEMS'] as $item) {
					?>
					<div class="swiper-slide">
						<div class="novelty-item">
							<a href="<?=$item['DETAIL_PAGE_URL']?>" class="novelty-item__image">
								<img src="<?=\CU_Goods_Helper::getProductScaledImage($item['DETAIL_PICTURE']['ID'], 'novelties')?>" alt="<?=$item['NAME']?>">
							</a>
							<div class="text-center pt-2 px-3">
								<a href="<?=$item['DETAIL_PAGE_URL']?>" class="novelty-item__title link-dark"><?=$item['NAME']?></a>
								<div class="novelty-item__prices">
									<?
									if ($item['ITEM_START_PRICE']['PRINT_PRICE']) {
										$skuPrice = $item['ITEM_START_PRICE']['PRINT_PRICE'];
										$skuPrice = 'От ' . $skuPrice;
										echo '<span class="fw-bold fs-5">' . $skuPrice . '</span>';
									} else {
										if ($item['ITEM_PRICES'][0]['PRINT_PRICE'] == $item['ITEM_PRICES'][0]['PRINT_BASE_PRICE']) {
											echo '<span class="fw-bold fs-5">' . $item['ITEM_PRICES'][0]['PRINT_PRICE'] .'</span>';
										} else {
										?>
											<span class="fw-bold fs-5"><?=$item['ITEM_PRICES'][0]['PRINT_PRICE']?></span>
											<span class="text-decoration-line-through"><?=$item['ITEM_PRICES'][0]['PRINT_BASE_PRICE']?></span>
										<?
										}
									}?>
								</div>
								<?
								if ($item['PROPERTIES']['vote_count']['VALUE']) {
	//								$rating = $item['PROPERTIES']['rating']['VALUE'];
									$rating = (int)$item['PROPERTIES']['vote_sum']['VALUE'] / (int)$item['PROPERTIES']['vote_count']['VALUE'];
									$rating = round($rating);
									if ($rating) {
									?>
										<div class="novelty-item__rating">
											<?
											for ($i=1;$i<=5;$i++) {
												if ($rating >= $i) {
													//закрашенная
													echo '<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>';
												} else {
													echo '<svg class="uicon-star"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star"></use></svg>';
												}
											}
											?>
										</div>
									<?
									}
								}
								?>
							</div>
						</div>
					</div>
					<?
				}
				?>
			</div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
	</div>
</div>

<?php