<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Пользовательское соглашение");

$APPLICATION->IncludeComponent(
    "page.include",
    "content",
    array(
        "CHAIN_NAME" => "Пользовательское соглашение",
        "INCLUDE_PATCH" => "include/help/client/license.php",

    ),
    false
);

?>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>

