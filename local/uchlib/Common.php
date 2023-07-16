<?php

declare(strict_types=1);


if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}


class CU_Common
{
	/**
	 * Возвращает название файла с нужным разрешением в нужной директории
	 * @param string $path - полный путь к папке, где искать файл с нужным разрешением от корня сервера.
	 * @param string $extension - пример: "js"
	 * @return string
	 */
	public static function getAssetFilename(string $path, string $extension): string
	{
		$path = trim($path, '/\\');
		$pattern = DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . '*.' . $extension;
		$files = glob($pattern);
//		var_dump($files);
		if (count($files) != 1) {
			throw new LogicException("Ассет должен быть только 1");
		}
		$file = reset($files);
		return basename($file);
	}
}