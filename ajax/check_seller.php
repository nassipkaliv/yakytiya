<?php
require $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
//проверяет можно ли добавить товар в корзину - если он от другого производителя нежели имеющиеся в корзине - то нельзя

$sellerId = $_POST['sellerId'];
if ($sellerId) {
	//то, что в корзине - с таким же производителем?
	$sellerAlreadyInBasketId = \CU_Seller_Helper::getCurrentBasketSellerId();
	if ($sellerAlreadyInBasketId) {
		if ($sellerAlreadyInBasketId == $sellerId) {
			//в корзине товары такого же производителя
			echo 'OK';
		} else {
			// в корзине товары *другого* производителя.
			echo 'ERR';
		}
		die();
	}
	//корзина пустая
	echo 'OK';
	die();
}