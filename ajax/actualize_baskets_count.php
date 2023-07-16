<?php
require $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
includeBitrixModules();



//то, что в корзине - с таким же производителем?

//корзина пустая
echo json_encode([
		'actual'=> \CU_Goods_Helper::countActualGoods(),
		'delayed'=> \CU_Goods_Helper::countDelayedGoods()
	]
);
die();
