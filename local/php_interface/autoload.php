<?php

/*
 * Подключение autoload composer
*/
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/vendor/autoload.php")) {
	require_once($_SERVER["DOCUMENT_ROOT"] . "/local/vendor/autoload.php");
}

/*
 * и библиотеки классов текущего сайта /local/uchlib/
*/
function uchlib_autoload($class)
{
	if (stripos($class, 'CU_') === 0) {
		$source = '/local/uchlib/';
	} else {
		return false;
	}

	if (!class_exists($class, false)) {
		$parts = explode('_', $class);
		array_shift($parts);
		$fname = implode('/', $parts);
		include_once($_SERVER["DOCUMENT_ROOT"] . $source . $fname . '.php');
	}
}

spl_autoload_register('uchlib_autoload');

