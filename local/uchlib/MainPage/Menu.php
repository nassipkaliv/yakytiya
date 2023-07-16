<?php


class CU_MainPage_Menu
{
	const MAX_ELEMENTS = 15;

	public static function printMenu()
	{
//		self::printOldMenu();
		self::printNewMenu();
	}

	private static function printNewMenu()
	{
		$catalogEntries = self::getEntries(6);
		$brandsEntries = self::getEntries(5);
		$tourismEntries = self::getEntries(8);
		self::printNewStyleMenu($catalogEntries, $brandsEntries, $tourismEntries);
	}

	private static function printNewStyleMenu($catalog, $brands, $tourism)
	{
		$catalogClass = $catalog ? 'menu-item_dropdown' : '';
		$brandsClass = $brands ? 'menu-item_dropdown' : '';
		$tourismClass = $tourism ? 'menu-item_dropdown' : '';
		?>
		<ul class="menu" id="js-menu">
			<li class="menu-item <?=$catalogClass?>">
				<a href="/catalog/">Каталог</a>
				<?
				self::printMenuCategory($catalog);
				?>
			</li>

			<li class="menu-item <?=$brandsClass?>">
				<a href="/seller/">Бренды</a>
				<?
				self::printMenuCategory($brands);
				?>
			</li>
			<li class="menu-item <?=$tourismClass?>">
				<a href="/tourism/">Туризм</a>
				<?
				self::printMenuCategory($tourism);
				?>
			</li>
		</ul>
		<?php
	}

	private static function printMenuCategory($category)
	{
		if ($category) {
			?>
			<span class="menu__second">
				<span class="container d-block">
					<ul class="menu__second-list">
						<?
						foreach ($category as $enty) {
							$isSub = !empty($enty['SUB']);
							$isSubClass = $isSub ? 'menu-item_dropdown' : '';
						?>
							<li class="menu-item <?=$isSubClass?>">
								<a href="<?=$enty['LOC']?>"><span><?=$enty['TEXT']?></span></a>
								<?
								if ($isSub) {
									?>
									<span class="menu__third">
										<ul>
											<?
											$isFirst = true;
											foreach ($enty['SUB'] as $sub) {
												if ($isFirst === true) {
													echo '<li><a href="'.$enty['LOC'].'">Все товары</a></li>';
													$isFirst = false;
												}
											?>
												<li><a href="<?=$sub['LOC']?>"><?=$sub['TEXT']?></a></li>
											<?
											}
											?>
										</ul>
									</span>
									<?
								}
								?>
							</li>
						<?
						}
						?>
					</ul>
				</span>
			</span>
			<?
		}
	}

	private static function getEntries($iblock)
	{
		$catalogEntries = [];
		$db_list = CIBlockSection::GetList(
			['SORT' => 'ASC'],
			$arFilter = [
				"IBLOCK_ID" => $iblock,
				'UF_SHOW_IN_MENU' => 1  //сделано через пользовательское свойство
			],
			true,
			$arSelect = ["UF_SHOW_IN_MENU", 'SECTION_ID']
		);

		$counter = 0;
		while ($ar_result = $db_list->GetNext()) {
			if ($ar_result['UF_SHOW_IN_MENU']) {
				$counter++;
				if ($counter > self::MAX_ELEMENTS) {
					break;
				}
				$subsections = \CU_MainPage_Menu::getSubsections($ar_result['ID']);

				$catalogEntries[] = [
					'LOC' => $ar_result['SECTION_PAGE_URL'],
					'TEXT' => $ar_result['NAME'],
					'SUB' => $subsections
				];
			}
		}
		$catalogEntries = self::filterDuplicatesForMenu($catalogEntries);
		return $catalogEntries;
	}

	private static function filterDuplicatesForMenu($catalogEntries)
	{
		//потому, что пользовательское свойство показа в меню может быть проставлено на любой вложенности
		//и он может попасть и в главную выборку и в выборку подразделов.
		$filtered = []; //одобренные

		$set = [];  //листья - которые не должны повторяться
		foreach ($catalogEntries as $entry) {
			if ($entry['SUB']) {
				foreach ($entry['SUB'] as $sub) {
					$set[$sub['LOC']] = $sub['LOC'];
				}
			}
		}

		foreach ($catalogEntries as $entry) {
			if ($entry['SUB'] || !in_array($entry['LOC'], $set)) {
				$filtered[] = $entry;
			}
		}

		return $filtered;
	}

	private static function getSubsections($parentSectionId)
	{
		$db_list = CIBlockSection::GetList(
			['SORT' => 'ASC'],
			$arFilter = [
				"IBLOCK_ID" => 6,
				'UF_SHOW_IN_MENU' => 1,  //сделано через пользовательское свойство
				'SECTION_ID' => $parentSectionId
			],
			true,
			$arSelect = ["UF_SHOW_IN_MENU", 'SECTION_ID']
		);
		$subsections = [];
		while ($ar_result = $db_list->GetNext()) {
			$subsections[] = [
				'LOC' => $ar_result['SECTION_PAGE_URL'],
				'TEXT' => $ar_result['NAME'],
			];
		}
		return $subsections;
	}

	private static function printOldMenu()
	{
		global $APPLICATION;
		$APPLICATION->IncludeComponent(
			'bitrix:menu',
			"bootstrap_v4",
			array(
				"ROOT_MENU_TYPE" => "left",
				"MENU_CACHE_TYPE" => "A",
				"MENU_CACHE_TIME" => "36000000",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_THEME" => "site",
				"CACHE_SELECTED_ITEMS" => "N",
				"MENU_CACHE_GET_VARS" => array(),
				"MAX_LEVEL" => "3",
				"CHILD_MENU_TYPE" => "left",
				"USE_EXT" => "Y",
				"DELAY" => "N",
				"ALLOW_MULTI_SELECT" => "N",
				"COMPONENT_TEMPLATE" => "bootstrap_v4"
			),
			false
		);
	}
}