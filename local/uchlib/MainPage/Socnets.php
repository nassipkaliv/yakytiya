<?php


class CU_MainPage_Socnets
{
	public static function printBottomSocnetsBlock()
	{
		//кажется не надо
		return;

		global $APPLICATION;
		$APPLICATION->IncludeComponent(
			"bitrix:eshop.socnet.links",
			"big_squares",
			array(
				"FACEBOOK" => "https://www.facebook.com/1CBitrix",
				"VKONTAKTE" => "https://vk.com/bitrix_1c",
				"TWITTER" => "https://twitter.com/1c_bitrix",
				"GOOGLE" => "https://plus.google.com/111119180387208976312/",
				"INSTAGRAM" => "https://instagram.com/1CBitrix/"
			),
			false,
			array(
				"HIDE_ICONS" => "N"
			)
		);
	}

	public static function printRightSocnetsBlock()
	{
		//кажется не надо
		return;

		?>
		<h3>Мы в соцсетях</h3>
		<?php
		global $APPLICATION;
		$APPLICATION->IncludeComponent(
			"bitrix:eshop.socnet.links",
			"bootstrap_v4",
			array(
				"COMPONENT_TEMPLATE" => "bootstrap_v4",
				"FACEBOOK" => "https://www.facebook.com/1CBitrix",
				"VKONTAKTE" => "https://vk.com/bitrix_1c",
				"TWITTER" => "https://twitter.com/1c_bitrix",
				"GOOGLE" => "https://plus.google.com/111119180387208976312/",
				"INSTAGRAM" => "https://instagram.com/1CBitrix/"
			),
			false,
			array(
				"HIDE_ICONS" => "N"
			)
		);
	}
}