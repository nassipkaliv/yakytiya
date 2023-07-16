<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
CJSCore::Init(array("fx"));

//\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
$asset = \Bitrix\Main\Page\Asset::getInstance();
//$asset->addCss(SITE_TEMPLATE_PATH . '/bootstrap_5.0.2/bootstrap.min.css');
//$asset->addJs(SITE_TEMPLATE_PATH . '/bootstrap_5.0.2/bootstrap.bundle.min.js');

if (isset($_GET["theme"]) && in_array($_GET["theme"], array("blue", "green", "yellow", "red")))
{
	COption::SetOptionString("main", "wizard_eshop_bootstrap_theme_id", $_GET["theme"], false, SITE_ID);
}
$theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "green", SITE_ID);

$curPage = $APPLICATION->GetCurPage(true);
$cssFilename = \CU_Common::getAssetFilename($_SERVER['DOCUMENT_ROOT'] . '/local/templates/adaptive/markup/dist/assets/', 'css');
$jsFilename = \CU_Common::getAssetFilename($_SERVER['DOCUMENT_ROOT'] . '/local/templates/adaptive/markup/dist/assets/', 'js');

includeBitrixModules();

?><!doctype html>
<html lang="en" class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Единая торговая площадка «Сделано в Якутии»</title>
	<!--Обратите внимание на type="module" - это должно остаться также, не type="javascript"-->
	<script type="module" crossorigin src="/local/templates/adaptive/markup/dist/assets/<?= $jsFilename ?>"></script>
	<link rel="stylesheet" href="/local/templates/adaptive/markup/dist/assets/<?= $cssFilename ?>">
	<? $APPLICATION->ShowHead(); ?>
</head>

<body class="d-flex flex-column h-100 layout">
	<?
	if (isMainPage()) {
		?>
		<!-- Блок layout__page-loader нужно подключать только на главной странице. -->
		<div class="layout__page-loader" id="js-page-loader">
			<img src="/local/templates/adaptive/markup/imgs/logo.svg" alt="Якутия - единая торговая площадка">
		</div><?
	}
	?>
	<div id="panel"><? /*$APPLICATION->ShowPanel();*/ ?></div>

	<header class="header">
		<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
			<div class="container position-relative">
				<div class="menu-block" id="js-menu-block">
					<span class="menu-block__toggler" id="js-menu-toggler">
						<svg class="uicon-menu_toggler"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#menu_toggler"></use></svg>
						<svg class="uicon-menu_cross"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#menu_cross"></use></svg>
					</span>
					<?
					\CU_MainPage_Menu::printMenu();
					?>
				</div>
				<a class="navbar-brand" href="/">
					<img src="/local/templates/adaptive/markup/imgs/logo.svg" alt="Якутия - единая торговая площадка">
				</a>
				<div class="header__search">
					<span class="header__search-toggler" id="js-search-toggler">
						<svg class="uicon-search_toggler"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#search_toggler"></use></svg>
					</span>
					<form role="search" class="header__search-form" id="js-search-form" data-bs-theme="light" action="/search/">
						<input class="form-control header__search-input" type="search" placeholder="Искать товары и бренды"
						       aria-label="Искать товары и бренды" name="q">
						<button class="header__search-btn" type="submit">
							<svg class="uicon-search"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#search"></use></svg>
						</button>
						<button class="header__search-cancel" type="button" id="js-mobile-cancel">
							<svg class="uicon-search_cross"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#search_cross"></use></svg>
						</button>
					</form>
				</div>
				<div class="header__personal">
					<?
					//todo!
					\CU_Layout_HeaderHelper::printPersonalBlock();
					?>
					<a href="/favourites/" class="header__favorites">
						<svg class="uicon-heart"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#heart"></use></svg>
						<span class="badge rounded-circle bg-danger">
	                        <span class="badge-inner"><?=\CU_Goods_Helper::countDelayedGoods()?></span>
	                    </span>
					</a>
					<a href="/personal/cart/" class="header__personal-item header__basket">
						<svg class="uicon-bag"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#bag"></use></svg>
						<span class="badge rounded-circle bg-danger">
							<span class="badge-inner"><?=\CU_Goods_Helper::countActualGoods()?></span>
						</span>
					</a>
				</div>
			</div>
		</nav>
		<div class="mobile-bottom-nav">
			<a href="/"><svg class="uicon-home_gray"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#home_gray"></use></svg></a>
			<a href="/favourites/" class="mobile-bottom-nav__favorites">
				<svg class="uicon-heart_gray_no_bg"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#heart_gray_no_bg"></use></svg>
				<span class="badge rounded-circle bg-danger">
					<span class="badge-inner">12</span>
				</span>
			</a>
			<a href="/personal/cart/" class="mobile-bottom-nav__basket">
				<svg class="uicon-bag_gray"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#bag_gray"></use></svg>
				<span class="badge rounded-circle bg-danger">
					<span class="badge-inner">21</span>
				</span>
			</a>
			<a href="/personal/">
				<svg class="uicon-user_gray"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#user_gray"></use></svg>
			</a>
		</div>

		<?/*?>
				<div class="bx-header-section container">
					<!--region bx-header-->
					<div class="row pt-0 pt-md-3 mb-3 align-items-center" style="position: relative;">
						<div class="d-block d-md-none bx-menu-button-mobile" data-role='bx-menu-button-mobile-position'></div>
						<div class="col-12 col-md-auto bx-header-logo">
							<a class="bx-logo-block d-none d-md-block" href="<?=SITE_DIR?>">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include/company_logo.php"),
									false
								);?>
							</a>
							<a class="bx-logo-block d-block d-md-none text-center" href="<?=SITE_DIR?>">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include/company_logo_mobile.php"
									),
									false
								);?>
							</a>
						</div>

						<div class="col-auto d-none d-md-block bx-header-personal">
							<?$APPLICATION->IncludeComponent(
								"bitrix:sale.basket.basket.line",
								"bootstrap_v4",
								array(
									"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
									"PATH_TO_PERSONAL" => SITE_DIR."personal/",
									"SHOW_PERSONAL_LINK" => "N",
									"SHOW_NUM_PRODUCTS" => "Y",
									"SHOW_TOTAL_PRICE" => "Y",
									"SHOW_PRODUCTS" => "N",
									"POSITION_FIXED" =>"N",
									"SHOW_AUTHOR" => "Y",
									"PATH_TO_REGISTER" => SITE_DIR."login/",
									"PATH_TO_PROFILE" => SITE_DIR."personal/"
								),
								false,
								array()
							);?>
						</div>

						<div class="col bx-header-contact">
							<div class="d-flex align-items-center justify-content-between justify-content-md-center flex-column flex-sm-row flex-md-column flex-lg-row">
								<div class="p-lg-3 p-1">
									<div class="bx-header-phone-block">
										<i class="bx-header-phone-icon"></i>
										<span class="bx-header-phone-number">
											<?$APPLICATION->IncludeComponent(
												"bitrix:main.include",
												"",
												array(
													"AREA_FILE_SHOW" => "file",
													"PATH" => SITE_DIR."include/telephone.php"
												),
												false
											);?>
										</span>
									</div>
								</div>
								<div class="p-lg-3 p-1">
									<div class="bx-header-worktime">
										<div class="bx-worktime-title"><?=GetMessage('HEADER_WORK_TIME'); ?></div>
										<div class="bx-worktime-schedule">
											<?$APPLICATION->IncludeComponent(
												"bitrix:main.include",
												"",
												array(
													"AREA_FILE_SHOW" => "file",
													"PATH" => SITE_DIR."include/schedule.php"
												),
												false
											);?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--endregion-->

					<!--region menu-->
					<div class="row mb-4 d-none d-md-block">
						<div class="col">
							<?
							\CU_MainPage_Menu::printMenu();

							\CU_MainPage_Includes::printSearch();
							?>
						</div>
					</div>


					<!--region breadcrumb-->
					<?if ($curPage != SITE_DIR."index.php"):?>
						<div class="row mb-4">
							<div class="col" id="navigation">
								<?$APPLICATION->IncludeComponent(
									"bitrix:breadcrumb",
									"universal",
									array(
										"START_FROM" => "0",
										"PATH" => "",
										"SITE_ID" => "-"
									),
									false,
									Array('HIDE_ICONS' => 'Y')
								);?>
							</div>
						</div>
						<h1 id="pagetitle"><?$APPLICATION->ShowTitle(false);?></h1>
					<?endif?>
					<!--endregion-->
				</div>
		<?*/?>
	</header>


