<?php

use Bitrix\Sale;
use Bitrix\Main\Loader;

class CU_Seller_Helper
{
    public static function getSellerData($sellerId)
    {
        $arSort = ['created' => 'DESC', 'ID' => 'DESC'];
        $arFilter = [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => 5,
            'ID' => $sellerId
        ];
        $arSelect = ['ID',
            'IBLOCK_ID',
            'DETAIL_PICTURE',
            'PREVIEW_PICTURE',
            'PROPERTY_DELIVERY',
            'PROPERTY_CONTACTS',
            'PROPERTY_TOURISM_DIRECTIONS',
            'PROPERTY_TOURISM_SERVICES',
            'PROPERTY_MORE_PHOTO'
        ];
        $query = CIBlockElement::getList($arSort, $arFilter, false, ['nTopCount' => 1], $arSelect);
        while ($cursor = $query->fetch()) {
            if ($cursor["PREVIEW_PICTURE"]) {
                $picture = CFile::GetFileArray($cursor["PREVIEW_PICTURE"]);
                if ($picture) {
                    $src = $picture['SRC'];
                    $cursor['SRC'] = $src;
                }
            }
            $morePhotos = [];
            if ($cursor["PROPERTY_MORE_PHOTO_VALUE"]) {
                foreach ($cursor["PROPERTY_MORE_PHOTO_VALUE"] as $morePhoto) {
                    $picture = CFile::GetFileArray($morePhoto);
                    if ($picture) {
                        $morePhotos[] = $picture['SRC'];
                    }
                }
            }
            $cursor['MORE_PHOTOS'] = $morePhotos;
            return $cursor;
        }
    }

    public static function displayMorePhotos($arPhotos)
    {
        if ($arPhotos) {
            foreach ($arPhotos as $photo) {
            ?>
                <div><img src="<?=$photo?>"></div>
            <?php
            }
        }
    }

    public static function printSellerDeliveries($sellerData)
    {
        if ($sellerData['PROPERTY_DELIVERY_VALUE']) {
            echo '<h4>Доставки</h4>';
            echo '<ul>';
            foreach ($sellerData['PROPERTY_DELIVERY_VALUE'] as $delviery) {
               echo '<li>' . $delviery . '</li>';
            }
            echo '</ul>';
        }
    }

    public static function printSellerContacts($sellerData)
    {
        if ($sellerData['PROPERTY_CONTACTS_VALUE']['TEXT']) {
            ?>
            <h4>Контакты</h4>
            <div><?=$sellerData['PROPERTY_CONTACTS_VALUE']['TEXT']?></div>
            <?php
        }
    }

    /** есть логика, что в корзине товары разных производителей не смешиваются. возвращает производителя актуальной корзины
     * @return void
     */
    public static function getCurrentBasketSellerId()
    {
        Loader::includeModule('sale');
        $fuserId = \CSaleBasket::GetBasketUserID(false);
        $basketRes = Sale\Internals\BasketTable::getList(array(
            'filter' => array(
                'ORDER_ID' => null,
                'CAN_BUY' => 'Y',
                'DELAY' => 'N',
                'FUSER_ID' => $fuserId
            )
        ));
        if ($item = $basketRes->fetch()) {
            $productId = $item['PRODUCT_ID'];
            $producerData = \CU_Goods_Helper::getProductProducerData($productId);
            return $producerData['ID'];
        }
    }

    public static function constructUrlToCard($sellerId)
    {
        return '/seller/e' . $sellerId . '/';
    }
}
