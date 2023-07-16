<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//дерево категорий товаров посмотрел тут: https://etp14.ru/product-category/

die();  //уже выполнено

if ($GLOBALS['USER']->IsAdmin()) {

	function createSection($name, $parentSection = null)
	{
		$IBLOCK_ID = 6;
		$ACTIVE = 'Y';

		$bs = new CIBlockSection;
		$arFields = Array(
			"ACTIVE" => $ACTIVE,
			"IBLOCK_ID" => $IBLOCK_ID,
			"NAME" => $name,
		);
		if ($parentSection) {
			$arFields["IBLOCK_SECTION_ID"] = $parentSection;
		}

		$id = $bs->Add($arFields);
		return $id;
	}

	\Bitrix\Main\Loader::includeModule('catalog');
	\Bitrix\Main\Loader::includeModule('iblock');

	$arGoodsSections = [
		'Детям' => [
			'3Д книги','Детская одежда','Якутские куклы'
		],
		'Для дома' => [
			'Натуральная косметика',
		    'Шаблоны для вышивания',
		    'Шторы и текстиль',
		],
		'Игры' => 'Игры',
		'Книги и ежедневники' => [
			'Ежедневники'
		],
		'Лодки' => 'Лодки',
		'Мастер-классы' => 'Мастер-классы',
		'Одежда' => [
			'Блузки, свитера, худи',
		    'Брюки',
		    'Головные уборы',
		    'Костюм',
		    'Пальто',
		    'Платья',
		    'Платья - халадаай',
		    'Юбки',
		],
		'Панно' => 'Панно',
		'Подарки' => 'Подарки',
		'Прочие товары' => [
			'Гаражи',
		    'Ножницы',
		    'Палатки',
		    'Печати',
		    'Штампы и печати',
		],
		'Сувениры' => 'Сувениры',
		'Сумки' => ['Кошельки'],
		'Туризм' => ['Орто Дойду'],
		'Украшения' => [
			'Айар Уус',
		    'Браслеты',
		    'Броши',
		    'Киэргэ',
		    'Колье, ожерелья',
		    'Кольца',
		    'Комплекты',
		    'Подвески',
		    'Серьги',
		    'Узор Утум',
		    'Украшения на голову',
		    'Этнические украшения',
		],
		'Хомус' => 'Хомус',
		'Цифровые товары' => ['Мастер-классы'],
		'Экопродукты' => [
			'Варенья',
		    'Выпечка',
		    'Десерты и пирожные',
		    'Мед',
		    'Микрозелень',
		    'Мясные полуфабрикаты',
		    'Напитки ',
		    'Пастила',
		    'Рыба',
		    'Сахачай',
		    'Сиропы',
		    'Соки-витграсс и детокс',
		    'Сыры',
		    'Торты',
		    'Чай',
		    'Чипсы',
		    'Шоколад ручной работы',
		    'Шоколадная паста',
		    'ЯГМЗ',
		    'ЯХК',
		],
		'Якутская посуда' => [
			'75 лет Победы',
		    'Камелек',
		    'Кытыйа, пиалы',
		    'Наборы',
		    'Сервизы',
		    'Чороон XXI век',
		    'Чорооны',
		],
		'Якутские ножи' => [
			'Бырдык Уус',
		    'Наборы',
		    'Ножи',
		    'Ножницы',
		]
	];

	foreach ($arGoodsSections as $sectionKey => $sectionVal) {
		$id = createSection($sectionKey, null);
		if (is_array($sectionVal)) {
			foreach ($sectionVal as $subsection) {
				createSection($subsection, $id);
			}
		}
	}

	//а тут три вложенности

	//Обувь (16)
	//    Обувь женская (11)
	//        Сапоги женские (3)
	//        Унты женские (8)
	//    Обувь мужская (5)
	//        Сапоги мужские (1)
	//        Унты мужские (3)
	//	];
	$shoes = createSection('Обувь', null);
		$womanShoes = createSection('Обувь женская', $shoes);
			$womanShoes = createSection('Сапоги женские', $womanShoes);
			$womanShoes = createSection('Унты женские', $womanShoes);
		$manShoes = createSection('Обувь мужская', $shoes);
			$manShoes = createSection('Сапоги мужские', $manShoes);
			$manShoes = createSection('Унты мужские', $manShoes);

} else {
	echo 'Forbidden';
}

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");