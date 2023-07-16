<?php
class CMainBanner extends CBitrixComponent
{
	public function executeComponent()
	{
		if ($this->arParams['ACTIVE'] != 'Y') {
			//выключен из параметров
			return;
		}

		$this->fillBanners($this->arParams['IBLOCK_ID']);
		if (!count($this->arResult['BANNERS'])) {
			//не нашлось активных баннеров
			return;
		}

		$this->IncludeComponentTemplate();
	}

	private function fillBanners($iblockId)
	{
		$iframeClass = 'd-block w-100 embed-responsive embed-responsive-16by9';
		$imgClass = 'd-block w-100';

		$arOrder = ["SORT"=>"ASC"];
		$arFilter = ["IBLOCK_ID" => $iblockId, 'ACTIVE' => 'Y'];
		$arGroupBy = false;
		$arNavStartParams = false;
		$arSelect = ['ID', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_YOUTUBE_IFRAME', 'PROPERTY_LINK_HREF', 'PROPERTY_ANIMATION_MOVE', 'PROPERTY_ANIMATION_SCALE'];
		$rsElement = CIBlockElement::GetList($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelect);

		while ($arElement = $rsElement->GetNext()) {
			if ($arElement['PROPERTY_YOUTUBE_IFRAME_VALUE']['TEXT']) {
				$iframe = htmlspecialcharsback($arElement['PROPERTY_YOUTUBE_IFRAME_VALUE']['TEXT']);
				$this->arResult['BANNERS'][] = [
					'VIDEO' => '<div class="' . $iframeClass . '">' . $iframe . '</div>'
				];
			} elseif ($arElement["DETAIL_PICTURE"]) {
				$detalPicture = CFile::GetFileArray($arElement["DETAIL_PICTURE"]);
				if ($detalPicture) {
					$src = $detalPicture['SRC'];
					$this->arResult['BANNERS'][] = [
						'PICTURE' => '<img src="'.$src.'" class="' . $imgClass . '" alt="" title="">',
						'LINK_HREF' => $arElement['PROPERTY_LINK_HREF_VALUE'],
						'ANIMATION_MOVE' => $arElement['PROPERTY_ANIMATION_MOVE_VALUE'],
						'ANIMATION_SCALE' => $arElement['PROPERTY_ANIMATION_SCALE_VALUE'],
					];
				}
			}
		}
	}
}