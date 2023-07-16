<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Доставка");

$APPLICATION->IncludeComponent(
    "page.include",
    "content",
    array(
        "CHAIN_NAME" => "Доставка",
        "INCLUDE_PATCH" => "include/help/client/delivery.php",

    ),
    false
);

?>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>
