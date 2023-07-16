<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Успешная отправка данных");
$APPLICATION->AddChainItem("Успешная отправка данных"); ?>
<?php
//http://127.0.0.8/tourism/success.php?WEB_FORM_ID=1&RESULT_ID=5&formresult=addok
//возможно понадобится каое-то письмо после заполнения заявки.
//наверное даже не тут его правильно обрабатывать, а хендлер на заполнение вебформы. и куда-нибудь в init.php
//но пока не делаем, а тут легче будет об этом вспомнить
?>
<p>
	<div class='alert alert-success'>Ваша заявка отправлена на рассмотрение.</div>
	<div>С Вами сявжутся для уточнения деталей</div>
</p>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>