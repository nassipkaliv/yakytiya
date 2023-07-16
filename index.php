<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин \"Одежда\"");
?>
<main class="flex-shrink-0 mb-5">
    <div class="homepage">
        <div id="fullpage">
            <??>
            <div class="section">
                <?//баннер
                \CU_MainPage_Banner::printBanner();?>
            </div>
            <div class="section">
                <?//популярные категории товаров
                \CU_MainPage_GoodsBlock::printPopularCategories();?>
            </div>
            <div class="section">
                <?//новинки
                \CU_MainPage_GoodsBlock::printNovelties();
                //блок рекламы под новинками
                \CU_MainPage_GoodsBlock::printUnderNoveltiesBanner();
                ?>
            </div>
            <div class="section">
                <?//популярные товары
                \CU_MainPage_GoodsBlock::printPopularGoods();?>
            </div>
            <div class="section">
                <?//лучшие предложения
                \CU_MainPage_GoodsBlock::printBestOffers();?>
            </div>
            <??>
            <div class="section">
                <?//популярные бренды
                CU_MainPage_GoodsBlock::printPopularBrands();?>
            </div>
        </div>
    </div>
</main>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>