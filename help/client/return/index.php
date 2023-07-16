<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Возврат");

$APPLICATION->IncludeComponent(
    "page.include",
    "content",
    array(
        "CHAIN_NAME" => "Возврат",
        "INCLUDE_PATCH" => "include/help/client/return.php",

    ),
    false
);

?>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>

