<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?php
	//тут не надо
	//\CU_MainPage_Includes::printSearch();
?>



<div class="mb-5">

	<?
	\CU_MainPage_Socnets::printRightSocnetsBlock();
	?>
</div>

<div class="mb-5 d-block d-sm-none">
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => SITE_DIR."include/sender.php",
			"AREA_FILE_RECURSIVE" => "N",
			"EDIT_MODE" => "html",
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
</div>

<?
\CU_MainPage_Includes::printAbout();
?>

<?php
\CU_MainPage_Includes::printTwitter();
?>

<?php
\CU_MainPage_Includes::printInfo();
?>
