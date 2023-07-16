<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Контакты");

$APPLICATION->IncludeComponent(
	"page.include",
	"content",
	array(
		"CHAIN_NAME" => "Контакты",
		"INCLUDE_PATCH" => "include/about/contacts.php",

	),
	false
);

?>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>
