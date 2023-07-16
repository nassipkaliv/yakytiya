<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Стать продавцом");

$APPLICATION->IncludeComponent(
    "page.include",
    "content",
    array(
        "CHAIN_NAME" => "Стать продавцом",
        "INCLUDE_PATCH" => "include/help/seller/start.php",

    ),
    false
);

?>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>

