<?php

class CU_Url_Helper
{
    public static function sectionDetail($sectionId)
    {
        return '/catalog/s'.$sectionId.'/';
    }

	public static function productDetail($productId)
	{
		return '/catalog/e' . $productId . '/';
	}
}