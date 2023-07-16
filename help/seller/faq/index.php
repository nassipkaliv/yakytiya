<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Вопросы и ответы");

$APPLICATION->IncludeComponent(
	"page.include",
	"content",
	array(
		"CHAIN_NAME" => "Продавцам: Вопросы и ответы",
		"INCLUDE_PATCH" => "include/help/seller/faq.php",

	),
	false
);

?>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>