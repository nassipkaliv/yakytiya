<?php
namespace lib\Personal;

trait HasCheckAuthorized
{
	/**
	 * Проверяем, авторизован пользователь или нет. Если нет, будет показана форма авторизации.
	 * @param string $msg
	 * @return bool
	 */
	function checkAuthorized(string $msg):bool
	{
		global $USER;
		global $APPLICATION;
		$isAuthorized = $USER->IsAuthorized();
		if (!$isAuthorized)
		{
			$APPLICATION->AuthForm($msg, false, false, 'N', false);
		}

		return $isAuthorized;
	}
}