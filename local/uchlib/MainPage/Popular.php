<?php


class CU_MainPage_Popular
{
	public static function filterPopularSections($allSections, $minGoodsCount)
	{
        $arPopular = [];
        $query = CIBlockSection::GetList(
            ['SORT' => 'ASC'],
            $arFilter = [
                "IBLOCK_ID" => 6,
                'UF_SHOW_IN_POPULAR' => 1  //сделано через пользовательское свойство
            ],
            true,
            $arSelect = ["ID"]
        );
        while ($cursor = $query->GetNext()) {
            $arPopular[] = $cursor["ID"];
        }

        foreach ($allSections as $section) {
            if (in_array($section['ID'],$arPopular)) {
                $goodSections[] = $section;
            }
        }
        return $goodSections;
	}
}