<?php

class CU_Layout_HeaderHelper
{
	public static function printPersonalBlock()
	{
		if ($GLOBALS['USER']->isAuthorized()) {
			self::printAthorizedPersonalBlock();
		} else {
			self::printUnathorizedPersonalBlock();
		}
	}

	private static function printUnathorizedPersonalBlock()
	{
		?>
		<a href="/personal/" class="header__cabinet">
			<svg class="uicon-user"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#user"></use></svg>
		</a>
		<?php
	}

	private static function printAthorizedPersonalBlock()
	{
		//todo! https://uchitel.planfix.ru/task/468163/?comment=9301439
		?>
		<a href="/personal/" class="header__cabinet">
			<svg class="uicon-user"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#user"></use></svg>
		</a>
		<?php
	}

}