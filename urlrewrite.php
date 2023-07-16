<?php

$arUrlRewrite = [
	1 =>
		[
			'CONDITION' => '#^/rest/#',
			'RULE' => '',
			'ID' => null,
			'PATH' => '/bitrix/services/rest/index.php',
			'SORT' => 100,
		],
	0 =>
		[
			'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
			'RULE' => 'componentName=$1',
			'ID' => null,
			'PATH' => '/bitrix/services/mobileapp/jn.php',
			'SORT' => 100,
		],
	2 =>
		[
			'CONDITION' => '#^/bitrix/services/ymarket/#',
			'RULE' => '',
			'ID' => '',
			'PATH' => '/bitrix/services/ymarket/index.php',
			'SORT' => 100,
		],
	3 =>
		[
			'CONDITION' => '#^/news/#',
			'RULE' => '',
			'ID' => 'bitrix:news',
			'PATH' => '/news/index.php',
			'SORT' => 100
		],
	7 =>
		[
			'CONDITION' => '#^/store/#',
			'RULE' => '',
			'ID' => 'bitrix:catalog.store',
			'PATH' => '/store/index.php',
			'SORT' => 100,
		],
	8 =>
		[
			'CONDITION' => '#^/catalog/#',
			'RULE' => '',
			'ID' => 'bitrix:catalog',
			'PATH' => '/catalog/index.php',
			'SORT' => 100,
		],
	9 =>
		[
			'CONDITION' => '#^/tourism/#',
			'RULE' => '',
			'ID' => 'bitrix:catalog',
			'PATH' => '/tourism/index.php',
			'SORT' => 100,
		],
	10 =>
		[
			'CONDITION' => '#^/seller/#',
			'RULE' => '',
			'ID' => 'bitrix:news',
			'PATH' => '/seller/index.php',
			'SORT' => 100,
		],
	11 =>
		[
			'CONDITION' => '#^/personal/seller/#',
			'RULE' => '',
			'ID' => 'seller.section',
			'PATH' => '/personal/seller/index.php',
			'SORT' => 100,
		],
	12 =>
		[
			'CONDITION' => '#^/personal/#',
			'RULE' => '',
			'ID' => 'personal.section',
			'PATH' => '/personal/index.php',
			'SORT' => 100,
		],
];
