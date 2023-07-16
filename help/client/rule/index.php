<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Правила продажи товаров на Единой торговой площадке «Сделано в Якутии»");

$APPLICATION->IncludeComponent(
    "page.include",
    "content",
    array(
        "CHAIN_NAME" => "Правила продажи товаров на Единой торговой площадке «Сделано в Якутии»",
        "INCLUDE_PATCH" => "include/help/client/rule.php",

    ),
    false
);

?>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>


