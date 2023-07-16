<?php
use Bitrix\Main\Application;

class CU_Template_Layout_Detector
{
	const FORCE_ADAPTIVE_FLAG_VALUE = 'Y';

	/**
	 * Массив разделов сайта, для которых необходимо использовать адаптивный шаблон
	 * @example
	 * '/' - главная страница сайта
	 * '/catalog/' - раздел каталога
	 * @var array
	 */
//	private static $directories = [
//		'/',
//	];

	/**
	 * Определяет, нужно ли ПОДКЛЮЧАТЬ адаптивный шаблон учмага
	 * @return bool
	 * @throws \Bitrix\Main\SystemException
	 */
	public static function isAdaptiveActive()
	{
		//еще один механизм для определения адаптивности страницы - через дефайн, размещаемый до подключения пролога.
		//это проще, чем программно в этом классе определять на какой странице находишься.
		if (defined('IS_ADAPTIVE_TEMPLATE')) {
			//чтобы через эту константу принудительно отключить адаптив, ее нужно определить в false
			return (IS_ADAPTIVE_TEMPLATE === true);
		}
		return false;

//		$request = Application::getInstance()->getContext()->getRequest();
//		return self::isAdaptiveActiveByRequest($request);
	}


//	/**
//	 * Определяет, что УЖЕ подключен адаптивный шаблон
//	 * @return bool
//	 */
//	public static function isAdaptiveAlreadyEnabled()
//	{
//		return SITE_TEMPLATE_ID === self::SITE_ADAPTIVE_TEMPLATE_ID;
//	}

	/**
	 * Метод определяет необходимость использования адаптивного шаблона сайта для текущего раздела
	 * @param \Bitrix\Main\HttpRequest $request
	 * @return bool
	 */
//	public static function isAdaptiveActiveByRequest(\Bitrix\Main\HttpRequest $request)
//	{
//		//для удобства отладки и быстрого переключения между обычным шаблоном и адаптивным,
//		// включение адаптива через GET параметр
//		if (
//			$request->get(self::FORCE_ADAPTIVE_FLAG) === self::FORCE_ADAPTIVE_FLAG_VALUE &&
//			//позволяем так делать только на деве и на бою только сотрудникам
//			(IsDevServer() || \CC_User::isCurrentUserUchitelStaff())
//		) {
//			return true;
//		}
//
//		// определяем находится ли пользователь на странице, для которой необходимо использовать адаптивный шаблон
//		$curPage = $request->getRequestedPage(); //пример: 'catalog/index.php'
//		foreach (self::$pages as $page) {
//			if ($page === $curPage) {
//				return true;
//			}
//		}
//
//		// определяем находится ли пользователь в разделе, для которого необходимо использовать адаптивный шаблон
//		$curDir =  $request->getRequestedPageDirectory();
//		$curDirWithEndSlash = $curDir . '/';
//		foreach (self::$directories as $directory) {
//			if ($directory === $curDirWithEndSlash) {
//				return true;
//			}
//		}
//
//		//определяем, подпадает ли текущая директория под какое-либо регулярное выражение
//		foreach (self::$directoriesRegExp as $directoryRegExp) {
//			$matchResult = preg_match($directoryRegExp, $curDirWithEndSlash);
//			if ($matchResult === false) {
//				throw new LogicException("Некорректный шаблон регулярного выражения: '$directoryRegExp'.");
//			}
//			if ($matchResult) {
//				return true;
//			}
//		}
//
//		return false;
//	}

//	/**
//	 * Определяет, что адаптивный шаблон по переданному праметру в $_REQUEST
//	 * @param string $paramName - название параметра в $_REQUEST запросе
//	 * @return bool
//	 */
//	public static function isAdaptiveActiveByRequestParameter($paramName = 'site_template_id')
//	{
//		$siteTemplateId = (string)@$_REQUEST[$paramName];
//		return ($siteTemplateId === self::SITE_ADAPTIVE_TEMPLATE_ID);
//	}


}