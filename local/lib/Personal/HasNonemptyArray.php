<?php
namespace lib\Personal;

trait HasNonemptyArray
{
	/**
	 * Function checks if it`s argument is a legal array for foreach() construction
	 * @param mixed $arr data to check
	 * @return boolean
	 */
	protected static function isNonemptyArray(mixed $arr): bool
	{
		return is_array($arr) && !empty($arr);
	}
}