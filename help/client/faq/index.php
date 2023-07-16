<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Вопросы и ответы");

$APPLICATION->IncludeComponent(
    "page.include",
    "content",
    array(
        "CHAIN_NAME" => "Покупателям: Вопросы и ответы",
        "INCLUDE_PATCH" => "include/help/client/faq.php",

    ),
    false
);

?>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>

