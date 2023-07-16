<?php
namespace lib\Personal;

use CIBlockFormatProperties;

trait HasFormatDate
{
	use HasNonemptyArray;

	/**
	 * Convert dates if date template set
	 * @param array $arr data array to be converted
	 * @param string[] $conversion contains sublist of keys of $arr, that will be converted
	 * @param string $activeDateFormat
	 * @return void
	 */
	protected function formatDate(array &$arr, array $conversion, string $activeDateFormat = "d.m.Y"): void
	{
		if (mb_strlen($activeDateFormat) && self::isNonemptyArray($conversion))
			foreach ($conversion as $fld)
			{
				if (!empty($arr[$fld]))
					$arr[$fld."_FORMATTED"] = CIBlockFormatProperties::DateFormat($activeDateFormat, MakeTimeStamp($arr[$fld]));
			}
	}
}