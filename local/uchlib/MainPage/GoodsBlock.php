<?php


class CU_MainPage_GoodsBlock
{
	public static function test() {
		echo '111111';
	}

	public static function printTrends()
	{
		global $trendFilter;
		global $APPLICATION;
		$trendFilter = array('PROPERTY_TREND' => '4');
		?>
		<h2>Тренды сезона</h2>
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"bootstrap_v4",
			array(
				"IBLOCK_TYPE_ID" => "catalog",
				"IBLOCK_ID" => "2",
				"BASKET_URL" => "/personal/cart/",
				"COMPONENT_TEMPLATE" => "",
				"IBLOCK_TYPE" => "catalog",
				"SECTION_ID" => $_REQUEST["SECTION_ID"],
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"FILTER_NAME" => "trendFilter",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"PAGE_ELEMENT_COUNT" => "12",
				"LINE_ELEMENT_COUNT" => "3",
				"PROPERTY_CODE" => array(
					0 => "NEWPRODUCT",
					1 => "",
				),
				"OFFERS_FIELD_CODE" => array(
					0 => "",
					1 => "",
				),
				"OFFERS_PROPERTY_CODE" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
					3 => "",
				),
				"OFFERS_SORT_FIELD" => "sort",
				"OFFERS_SORT_ORDER" => "desc",
				"OFFERS_SORT_FIELD2" => "id",
				"OFFERS_SORT_ORDER2" => "desc",
				"TEMPLATE_THEME" => "site",
				"PRODUCT_DISPLAY_MODE" => "Y",
				"ADD_PICT_PROP" => "MORE_PHOTO",
				"LABEL_PROP" => array(
					0 => "NEWPRODUCT"
				),
				"OFFER_ADD_PICT_PROP" => "-",
				"OFFER_TREE_PROPS" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
				),
				"PRODUCT_SUBSCRIPTION" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"SHOW_OLD_PRICE" => "Y",
				"SHOW_CLOSE_POPUP" => "N",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_SUBSCRIBE" => "Подписаться",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"SECTION_URL" => "",
				"DETAIL_URL" => "",
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"SEF_MODE" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_GROUPS" => "Y",
				"SET_TITLE" => "Y",
				"SET_BROWSER_TITLE" => "Y",
				"BROWSER_TITLE" => "-",
				"SET_META_KEYWORDS" => "Y",
				"META_KEYWORDS" => "-",
				"SET_META_DESCRIPTION" => "Y",
				"META_DESCRIPTION" => "-",
				"SET_LAST_MODIFIED" => "N",
				"USE_MAIN_ELEMENT_SECTION" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"CACHE_FILTER" => "N",
				"ACTION_VARIABLE" => "action",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRICE_CODE" => array(
					0 => "BASE",
				),
				"USE_PRICE_COUNT" => "N",
				"SHOW_PRICE_COUNT" => "1",
				"PRICE_VAT_INCLUDE" => "Y",
				"CONVERT_CURRENCY" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"PRODUCT_QUANTITY_VARIABLE" => "",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRODUCT_PROPERTIES" => array(
				),
				"OFFERS_CART_PROPERTIES" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
				),
				"ADD_TO_BASKET_ACTION" => "ADD",
				"PAGER_TEMPLATE" => "round",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"COMPATIBLE_MODE" => "N",
			),
			false
		);
	}

	public static function printPopularCategories()
	{
		//образец вёрстки для дебага
		//self::printPopularCategoriesMarkup(); return;

		?>
		<?php
		global $APPLICATION;
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"popular_categories",
			array(
				"ADD_SECTIONS_CHAIN" => "Y",
				"CACHE_FILTER" => "N",
				"COUNT_ELEMENTS" => "Y",
				"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
				"FILTER_NAME" => "sectionsFilter",
				"IBLOCK_ID" => "6",
				"IBLOCK_TYPE" => "catalog",
				"SECTION_CODE" => "",
				"SECTION_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"SECTION_ID" => $_REQUEST["SECTION_ID"],
				"SECTION_URL" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"SHOW_PARENT_NAME" => "Y",
				"TOP_DEPTH" => "3",
				"VIEW_MODE" => "TILE",
				"COMPONENT_TEMPLATE" => ".default",
				"HIDE_SECTION_NAME" => "N",
//				"CACHE_TYPE" => "A",
//				"CACHE_TIME" => "36000000",
//				"CACHE_GROUPS" => "Y"
//				'SALT' => time(),
				'SALT' => '6' . date('Y.m.d.H i'),	//внутри всё равно кэш работает. сбиваем его каждый час.
				'MIN_GOODS_COUNT' => 1  //>= стольки товаров в категории - значит популярная
			),
			false
		);
	}

	private static function printPopularCategoriesMarkup()
	{
		?>
		<div class="homepage__popular homepage__fp-slide-full-height">
			<h2 class="container-fluid homepage__h2">
				Популярные категории товаров
			</h2>
			<div class="homepage__popular-title">
				Популярные <br>
				категории <br>
				товаров
			</div>
			<div class="homepage__popular-items">
				<div class="homepage__popular-items-row">
					<a href="http://ya.ru"><img src="/local/templates/adaptive/markup/upload/popular/1.jpg" alt=""><span>Якутские Ножи</span></a>
					<a href="#"><img src="/local/templates/adaptive/markup/upload/popular/2.jpg" alt=""><span>Украшения</span></a>
				</div>
				<div class="homepage__popular-items-row">
					<a href="#"><img src="/local/templates/adaptive/markup/upload/popular/3.jpg" alt=""><span>Украшения</span></a>
					<a href="#"><img src="/local/templates/adaptive/markup/upload/popular/4.jpg" alt=""><span>Мед</span></a>
				</div>
				<div class="homepage__popular-items-row">
					<a href="#"><img src="/local/templates/adaptive/markup/upload/popular/5.jpg" alt=""><span>Национальная одеджа</span></a>
					<a href="#"><img src="/local/templates/adaptive/markup/upload/popular/6.jpg" alt=""><span>Национальная посуда</span></a>
				</div>
			</div>
		</div>
		<?php /*?>
		<div class="homepage__slide">
			<div class="homepage__slide-inner">
				<div class="homepage__popular">
					<h2 class="container-fluid homepage__h2">
						Популярные категории товаров
					</h2>
					<div class="homepage__popular-title">
						Популярные <br>
						категории <br>
						товаров
					</div>
					<div class="homepage__popular-items">
						<div class="homepage__popular-items-row">
							<a href="http://ya.ru"><img src="/local/templates/adaptive/markup/upload/popular/1.jpg" alt=""><span>Якутские Ножи</span></a>
							<a href="#"><img src="/local/templates/adaptive/markup/upload/popular/2.jpg" alt=""><span>Украшения</span></a>
						</div>
						<div class="homepage__popular-items-row">
							<a href="#"><img src="/local/templates/adaptive/markup/upload/popular/3.jpg" alt=""><span>Украшения</span></a>
							<a href="#"><img src="/local/templates/adaptive/markup/upload/popular/4.jpg" alt=""><span>Мед</span></a>
						</div>
						<div class="homepage__popular-items-row">
							<a href="#"><img src="/local/templates/adaptive/markup/upload/popular/5.jpg" alt=""><span>Национальная одеджа</span></a>
							<a href="#"><img src="/local/templates/adaptive/markup/upload/popular/6.jpg" alt=""><span>Национальная посуда</span></a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
        */
	}


	public static function printNovelties()
	{
		\CU_MainPage_GoodsBlock::printNovletiesNew();
//		\CU_MainPage_GoodsBlock::printNovletiesMarkup();
//		\CU_MainPage_GoodsBlock::printNoveltiesOld();
	}

	private static function printNovletiesMarkup()
	{
		?>
		<div class="homepage__slide homepage__slide_novelties">
			<div class="homepage__slide-inner">
				<h2 class="container-fluid homepage__h2">
					Новинки
				</h2>
				<!-- Swiper -->
				<div class="swiper swiper-novelties js-swiper-novelties">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="novelty-item">
								<a href="http://ya.ru" class="novelty-item__image">
									<img src="/local/templates/adaptive/markup/upload/catalog/novelty.jpg" alt="Платье серое">
								</a>
								<div class="text-center pt-2 px-3">
									<a href="#" class="novelty-item__title link-dark">Платье серое</a>
									<div class="novelty-item__prices">
										<span class="fw-bold fs-5">12 200 ₽</span>
										<span class="text-decoration-line-through">12 800 ₽</span>
									</div>
									<div class="novelty-item__rating">
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star"></use></svg>
									</div>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="novelty-item">
								<a href="http://ya.ru" class="novelty-item__image">
									<img src="/local/templates/adaptive/markup/upload/catalog/novelty.jpg" alt="Платье серое">
								</a>
								<div class="text-center pt-2 px-3">
									<a href="#" class="novelty-item__title link-dark">Промежуточный костюм универсальный с оленьей шерстью</a>
									<div class="novelty-item__prices">
										<span class="fw-bold fs-5">12 200 ₽</span>
										<span class="text-decoration-line-through">122 800 ₽</span>
									</div>
									<div class="novelty-item__rating">
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star"></use></svg>
									</div>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="novelty-item">
								<a href="http://ya.ru" class="novelty-item__image">
									<img src="/local/templates/adaptive/markup/upload/catalog/novelty.jpg" alt="Платье серое">
								</a>
								<div class="text-center pt-2 px-3">
									<a href="#" class="novelty-item__title link-dark">Платье национальное темно-серое со вставками</a>
									<div class="novelty-item__prices">
										<span class="fw-bold fs-5">12 200 ₽</span>
										<span class="text-decoration-line-through">12 800 ₽</span>
									</div>
									<div class="novelty-item__rating">
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star"></use></svg>
									</div>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="novelty-item">
								<a href="http://ya.ru" class="novelty-item__image">
									<img src="/local/templates/adaptive/markup/upload/catalog/novelty.jpg" alt="Платье серое">
								</a>
								<div class="text-center pt-2 px-3">
									<a href="#" class="novelty-item__title link-dark">Платье национальное темно-серое со вставками</a>
									<div class="novelty-item__prices">
										<span class="fw-bold fs-5">12 200 ₽</span>
										<span class="text-decoration-line-through">12 800 ₽</span>
									</div>
									<div class="novelty-item__rating">
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star"></use></svg>
									</div>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="novelty-item">
								<a href="http://ya.ru" class="novelty-item__image">
									<img src="/local/templates/adaptive/markup/upload/catalog/novelty.jpg" alt="Платье серое">
								</a>
								<div class="text-center pt-2 px-3">
									<a href="#" class="novelty-item__title link-dark">Платье национальное темно-серое со вставками</a>
									<div class="novelty-item__prices">
										<span class="fw-bold fs-5">12 200 ₽</span>
										<span class="text-decoration-line-through">12 800 ₽</span>
									</div>
									<div class="novelty-item__rating">
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star"></use></svg>
									</div>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="novelty-item">
								<a href="http://ya.ru" class="novelty-item__image">
									<img src="/local/templates/adaptive/markup/upload/catalog/novelty.jpg" alt="Платье серое">
								</a>
								<div class="text-center pt-2 px-3">
									<a href="#" class="novelty-item__title link-dark">Платье национальное темно-серое со вставками</a>
									<div class="novelty-item__prices">
										<span class="fw-bold fs-5">12 200 ₽</span>
										<span class="text-decoration-line-through">12 800 ₽</span>
									</div>
									<div class="novelty-item__rating">
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star"></use></svg>
									</div>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="novelty-item">
								<a href="http://ya.ru" class="novelty-item__image">
									<img src="/local/templates/adaptive/markup/upload/catalog/novelty.jpg" alt="Платье серое">
								</a>
								<div class="text-center pt-2 px-3">
									<a href="#" class="novelty-item__title link-dark">Платье национальное темно-серое со вставками</a>
									<div class="novelty-item__prices">
										<span class="fw-bold fs-5">12 200 ₽</span>
										<span class="text-decoration-line-through">12 800 ₽</span>
									</div>
									<div class="novelty-item__rating">
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star_active"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star_active"></use></svg>
										<svg class="uicon-star"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#star"></use></svg>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>


			</div>
		</div>

		<?php
	}

	private static function printNovletiesNew()
	{
		global $APPLICATION;
		global $noveltiesFilter;

		$ids = \CU_Goods_Helper::getIds_novelties(10, 6);
		$noveltiesFilter = ['ID' => $ids];

		$APPLICATION->IncludeComponent(
			"bitrix:catalog.top",
			"novelties_new",
			Array(
				"ACTION_VARIABLE" => "action",
				"ADD_PICT_PROP" => "-",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"ADD_TO_BASKET_ACTION" => "ADD",
				"BASKET_URL" => "/personal/basket.php",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "N",
				"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
				"COMPATIBLE_MODE" => "Y",
				"CONVERT_CURRENCY" => "N",
				"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
				"DETAIL_URL" => "",
				"DISCOUNT_PERCENT_POSITION" => "bottom-right",
				"DISPLAY_COMPARE" => "N",
				"ELEMENT_COUNT" => "9",
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER" => "asc",
				"ELEMENT_SORT_ORDER2" => "desc",
				"ENLARGE_PRODUCT" => "STRICT",
				"FILTER_NAME" => "",
				"HIDE_NOT_AVAILABLE" => "N",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"IBLOCK_ID" => "6",
				"IBLOCK_TYPE" => "catalog",
				"LABEL_PROP" => "TAG_MATERIAL",
				"LINE_ELEMENT_COUNT" => "3",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_COMPARE" => "Сравнить",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"OFFERS_FIELD_CODE" => array("",""),
				"OFFERS_LIMIT" => "5",
				"OFFERS_SORT_FIELD" => "sort",
				"OFFERS_SORT_FIELD2" => "id",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "desc",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRICE_CODE" => array("BASE"),
				"PRICE_VAT_INCLUDE" => "Y",
				"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
				"PRODUCT_DISPLAY_MODE" => "N",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PRODUCT_QUANTITY_VARIABLE" => "quantity",
				"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
				"PRODUCT_SUBSCRIPTION" => "N",
				"ROTATE_TIMER" => "30",
				"SECTION_URL" => "",
				"SEF_MODE" => "N",
				"SHOW_CLOSE_POPUP" => "N",
				"SHOW_DISCOUNT_PERCENT" => "Y",
				"SHOW_MAX_QUANTITY" => "N",
				"SHOW_OLD_PRICE" => "Y",
				"SHOW_PAGINATION" => "Y",
				"SHOW_PRICE_COUNT" => "1",
				"SHOW_SLIDER" => "Y",
				"SLIDER_INTERVAL" => "3000",
				"SLIDER_PROGRESS" => "N",
				"TEMPLATE_THEME" => "blue",
				"USE_ENHANCED_ECOMMERCE" => "N",
				"USE_PRICE_COUNT" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"VIEW_MODE" => "SLIDER",
				'SALT' => '8'
			),
			false
		);

		$noveltiesFilter = [];
	}


	private static function printNoveltiesOld()
	{
		?>
		<h2>Новинки</h2>
		<?php

		global $APPLICATION;
		global $noveltiesFilter;

		$ids = \CU_Goods_Helper::getIds_novelties(10, 6);
		$noveltiesFilter = ['ID' => $ids];

		$APPLICATION->IncludeComponent(
			"bitrix:catalog.top",
			"novelties",
			array(
				"ACTION_VARIABLE" => "action",
				"ADD_PICT_PROP" => "-",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"ADD_TO_BASKET_ACTION" => "ADD",
				"BASKET_URL" => "/personal/basket.php",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
				"COMPATIBLE_MODE" => "Y",
				"CONVERT_CURRENCY" => "N",
				"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
				"DETAIL_URL" => "",
				"DISPLAY_COMPARE" => "N",
				"ELEMENT_COUNT" => "9",
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER" => "asc",
				"ELEMENT_SORT_ORDER2" => "desc",
				"ENLARGE_PRODUCT" => "STRICT",
				"FILTER_NAME" => "noveltiesFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"IBLOCK_ID" => "6",
				"IBLOCK_TYPE" => "catalog",
				"LABEL_PROP" => [],
				"LINE_ELEMENT_COUNT" => "3",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_COMPARE" => "Сравнить",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"OFFERS_LIMIT" => "5",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRICE_CODE" => [
					0 => "base",
				],
				"PRICE_VAT_INCLUDE" => "Y",
				"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PRODUCT_QUANTITY_VARIABLE" => "quantity",
				"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
				"PRODUCT_SUBSCRIPTION" => "Y",
				"ROTATE_TIMER" => "30",
				"SECTION_URL" => "",
				"SEF_MODE" => "N",
				"SHOW_CLOSE_POPUP" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"SHOW_MAX_QUANTITY" => "N",
				"SHOW_OLD_PRICE" => "N",
				"SHOW_PAGINATION" => "Y",
				"SHOW_PRICE_COUNT" => "1",
				"SHOW_SLIDER" => "Y",
				"SLIDER_INTERVAL" => "3000",
				"SLIDER_PROGRESS" => "N",
				"TEMPLATE_THEME" => "blue",
				"USE_ENHANCED_ECOMMERCE" => "N",
				"USE_PRICE_COUNT" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"VIEW_MODE" => "SLIDER",
				"COMPONENT_TEMPLATE" => "novelties",
				'SALT' => 9
			),
			false
		);

		$noveltiesFilter = [];
	}

	/* место под рекламный баннер под новинками
	 * */
	public static function printUnderNoveltiesBanner()
	{
//		$iblockId = 8;  //а вот и разошлись айдишники. поэтому через код инфоблока
		$iblockId = CU_Iblock::getIdByCode('adv_with_novelties');

		$arOrder = ["SORT"=>"ASC"];
		$arFilter = ["IBLOCK_ID" => $iblockId, 'ACTIVE' => 'Y'];
		$arGroupBy = false;
		$arNavStartParams = false;
		$arSelect = ['ID','IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_URL_TO', 'NAME'];
		$rsElement = CIBlockElement::GetList($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelect);
		$arElements = [];

		while ($arElement = $rsElement->GetNext()) {
			$detalPicture = CFile::GetFileArray($arElement["DETAIL_PICTURE"]);
			$arElements[] = [
				'SRC' => $detalPicture['SRC'],
				'HREF' => $arElement["PROPERTY_URL_TO_VALUE"],
				'NAME' => $arElement['NAME']
			];
		}
		?>

		<?php
		if ($arElements) {
			?>
			<div class="homepage__adv">
				<div class="container-fluid">
					<div class="row">
						<?php
						foreach($arElements as $element) {
						?>
							<div class="col">
								<a href="<?=$element['HREF']?>"><img src="<?=$element['SRC']?>" alt="<?=$element['NAME']?>"></a>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		<?
		}
	}

	public static function printPopularGoods()
	{
		global $APPLICATION;
		$APPLICATION->IncludeComponent(
	"bitrix:sale.bestsellers", 
	"on_main_page", 
	array(
		"COMPONENT_TEMPLATE" => "on_main_page",
		"HIDE_NOT_AVAILABLE" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_NAME" => "Y",
		"SHOW_IMAGE" => "Y",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"PAGE_ELEMENT_COUNT" => "30",
		"TEMPLATE_THEME" => "blue",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"BY" => "QUANTITY",
		"PERIOD" => "0",
		"FILTER" => array(
			0 => "N",
			1 => "P",
			2 => "F",
		),
		"SHOW_OLD_PRICE" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"SHOW_PRODUCTS_2" => "N",
		"PROPERTY_CODE_2" => array(
		),
		"CART_PROPERTIES_2" => array(
		),
		"ADDITIONAL_PICT_PROP_2" => "MORE_PHOTO",
		"LABEL_PROP_2" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "86400",
		"SHOW_PRODUCTS_6" => "Y",
		"PROPERTY_CODE_6" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_6" => array(
			0 => "",
			1 => "",
		),
		"ADDITIONAL_PICT_PROP_6" => "MORE_PHOTO",
		"LABEL_PROP_6" => "-",
		//'SALT' => time()
		"SALT" => "7",
	),
	false
);
	}

	public static function printBestOffers()
	{
		?>
		<?php
		global $APPLICATION;
		global $discountedFilter;

		$ids = \CU_Goods_Helper::getIds_discounted(18);
		$discountedFilter = ['ID' => $ids];

		$APPLICATION->IncludeComponent(
			"bitrix:catalog.top",
			"discounted",
			array(
				"ACTION_VARIABLE" => "action",
				"ADD_PICT_PROP" => "-",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"ADD_TO_BASKET_ACTION" => "ADD",
				"BASKET_URL" => "/personal/basket.php",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "N",
				"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
				"COMPATIBLE_MODE" => "Y",
				"CONVERT_CURRENCY" => "N",
				"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
				"DETAIL_URL" => "",
				"DISPLAY_COMPARE" => "N",
				"ELEMENT_COUNT" => "18",
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER" => "asc",
				"ELEMENT_SORT_ORDER2" => "desc",
				"ENLARGE_PRODUCT" => "STRICT",
				"FILTER_NAME" => "discountedFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"IBLOCK_ID" => "6",
				"IBLOCK_TYPE" => "catalog",
				"LABEL_PROP" => [],
				"LINE_ELEMENT_COUNT" => "3",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_COMPARE" => "Сравнить",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"OFFERS_LIMIT" => "5",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRICE_CODE" => ["BASE"],
				"PRICE_VAT_INCLUDE" => "Y",
				"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PRODUCT_QUANTITY_VARIABLE" => "quantity",
				"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
				"PRODUCT_SUBSCRIPTION" => "Y",
				"ROTATE_TIMER" => "30",
				"SECTION_URL" => "",
				"SEF_MODE" => "N",
				"SHOW_CLOSE_POPUP" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"SHOW_MAX_QUANTITY" => "N",
				"SHOW_OLD_PRICE" => "N",
				"SHOW_PAGINATION" => "Y",
				"SHOW_PRICE_COUNT" => "1",
				"SHOW_SLIDER" => "Y",
				"SLIDER_INTERVAL" => "3000",
				"SLIDER_PROGRESS" => "N",
				"TEMPLATE_THEME" => "blue",
				"USE_ENHANCED_ECOMMERCE" => "N",
				"USE_PRICE_COUNT" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"VIEW_MODE" => "SLIDER",
				"COMPONENT_TEMPLATE" => "discounted",
				'SALT' => '1'
			),
			false
		);

		$discountedFilter = [];
	}

	public static function printPopularBrands()
	{
		global $APPLICATION;
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.top",
			"popular_brands",
			Array(
				"ACTION_VARIABLE" => "action",
				"ADD_PICT_PROP" => "-",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"ADD_TO_BASKET_ACTION" => "ADD",
				"BASKET_URL" => "/personal/basket.php",
				"CACHE_FILTER" => "N",
//				"CACHE_GROUPS" => "Y",
//				"CACHE_TIME" => "36000000",
//				"CACHE_TYPE" => "A",
				"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
				"COMPATIBLE_MODE" => "Y",
				"CONVERT_CURRENCY" => "N",
				"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
				"DETAIL_URL" => "",
				"DISPLAY_COMPARE" => "N",
				"ELEMENT_COUNT" => "10",
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER" => "asc",
				"ELEMENT_SORT_ORDER2" => "desc",
				"ENLARGE_PRODUCT" => "STRICT",
				"FILTER_NAME" => "",
				"HIDE_NOT_AVAILABLE" => "N",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"IBLOCK_ID" => "5",
				"IBLOCK_TYPE" => "catalog",
				"LABEL_PROP" => array(),
				"LINE_ELEMENT_COUNT" => "10",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_COMPARE" => "Сравнить",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"OFFERS_LIMIT" => "5",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRICE_CODE" => array(),
				"PRICE_VAT_INCLUDE" => "Y",
				"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PRODUCT_QUANTITY_VARIABLE" => "quantity",
				"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
				"PRODUCT_SUBSCRIPTION" => "Y",
				"ROTATE_TIMER" => "30",
				"SECTION_URL" => "",
				"SEF_MODE" => "N",
				"SHOW_CLOSE_POPUP" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"SHOW_MAX_QUANTITY" => "N",
				"SHOW_OLD_PRICE" => "N",
				"SHOW_PAGINATION" => "Y",
				"SHOW_PRICE_COUNT" => "1",
				"SHOW_SLIDER" => "Y",
				"SLIDER_INTERVAL" => "3000",
				"SLIDER_PROGRESS" => "N",
				"TEMPLATE_THEME" => "blue",
				"USE_ENHANCED_ECOMMERCE" => "N",
				"USE_PRICE_COUNT" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
//				"VIEW_MODE" => "SECTION"
				"VIEW_MODE" => "SLIDER",
				'SALT' => 8
			)
		);
	}

	public static function printDoubleSliderBlock($arItems)
	{
		$itemsCount = count($arItems);
		if ($itemsCount <= 9) {
			\CU_MainPage_GoodsBlock::printSliderRow($arItems);
		} else {
			$firstRow = $secondRow = [];
			$counter = 0;
			foreach ($arItems as $item) {
				if ($counter < 9 ) {
					$firstRow[] = $item;
				} else {
					$secondRow[] = $item;
				}
				$counter++;
				if ($counter == 18) {
					break;  //всего 18
				}
			}
			\CU_MainPage_GoodsBlock::printSliderRow($firstRow);
			\CU_MainPage_GoodsBlock::printSliderRow($secondRow);
		}
	}

	/** для бестселлеров и для лучших предложений
	 * @return void
	 */
	private static function printSliderRow($arItems)
	{
		$swiperClass = 'js-swiper-products-popular';
		?>
		<div class="swiper swiper-products <?=$swiperClass?>">
			<div class="swiper-wrapper">
				<?foreach ($arItems as $item) {
					?>
					<div class="swiper-slide">
						<div class="product-item">
							<a href="<?=\CU_Url_Helper::productDetail($item['ID'])?>" class="product-item__image">
								<img src="<?=\CU_Goods_Helper::getProductScaledImage($item['DETAIL_PICTURE']['ID'],'slider_row')?>" alt="<?=$item['NAME']?>">
								<?if (\CU_Goods_Helper::isFreeDelivery($item['ID'])) {?>
									<span class="product-item__label">Бесплатная доставка</span>
								<?}?>
							</a>
							<div class="text-center pt-2 px-3">
								<a href="<?=\CU_Url_Helper::productDetail($item['ID'])?>" class="product-item__title link-dark mb-0"><?=$item['NAME']?></a>
								<div class="product-item__prices">
									<?
									$basePrice = $item['PRICES']['BASE']['PRINT_VALUE'];
									$discountedPrice = $item['PRICES']['BASE']['PRINT_DISCOUNT_VALUE'];
									if ($discountedPrice && $basePrice != $discountedPrice) {
									?>
										<span class="fw-bold fs-5"><?=$discountedPrice?></span>
										<span class="text-decoration-line-through fw-light"><?=$basePrice?></span>
									<?} else { ?>
										<span class="fw-bold fs-5"><?=$basePrice?></span>
										<?
									}?>
								</div>
							</div>
						</div>
					</div>
				<?}?>
			</div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div><!-- Swiper -->
		<?php
	}
}