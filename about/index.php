<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("О магазине");

$APPLICATION->IncludeComponent(
	"page.include",
	"content",
	array(
		"CHAIN_NAME" => "О магазине",
		"INCLUDE_PATCH" => "include/about/about.php",

	),
	false
);

?>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>

