<?php

use Bitrix\Main;
use Bitrix\Main\Application;
use Bitrix\Sale\Order;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

class CSellerOrderCancel extends CBitrixComponent
{
    use lib\Personal\HasCheckAuthorized;
    use lib\Personal\HasSaleOrder;

    /**
     * @throws Main\SystemException
     */
    public function executeComponent(): void
    {
        try {
            $isAuthorized = $this->checkAuthorized('Для просмотра списка заказов необходимо авторизоваться');
            if (!$isAuthorized) {
                return;
            }

            $this->setFrameMode(false);
            $this->arResult["URL_TO_LIST"] = $this->arParams['PATH_TO_LIST'];

            $idOrder = intval(urldecode(urldecode($this->arParams["ID"])));
            if ($idOrder == '') {
                $this->showMessage("Номер заказа не может быть пустым");
                return;
            }

            $this->setTitle($idOrder);

            $order = Order::load($idOrder);

            if (!$order || $this->isOrderBelongsToUser($order->getField('USER_ID'))) {
                $this->showMessage(str_replace("#ID#", $idOrder, "Заказ №#ID# не найден."));
                return;
            }

            if ($order->isCanceled()) {
                $this->showMessage(str_replace("#ACCOUNT_NUMBER#", $idOrder, "Заказ №#ACCOUNT_NUMBER# отменен"));
                $this->includeComponentTemplate();
                return;
            }

            $request = Application::getInstance()->getContext()->getRequest();
            if ($request->get("CANCEL") == "Y" && $request->isPost()
                && $request->get("action") <> '' && check_bitrix_sessid()) {
                if ($order->isPaid() || $order->isShipped()) {
                    $this->arResult["ERROR_MESSAGE"] = "Невозможно отменить доставленный заказ и заказ, оплата за который уже получена.";
                } else {
                    $oldOrderObject = new CSaleOrder();
                    $oldOrderObject->CancelOrder($order->getId(), "Y", $_REQUEST["REASON_CANCELED"]);
                    global $APPLICATION;
                    if ($ex = $APPLICATION->GetException()) {
                        $errors[] = $ex->GetString();
                    } else {
                        LocalRedirect($this->arParams["PATH_TO_LIST"]);
                    }
                }
                if (!empty($errors) && is_array($errors)) {
                    foreach ($errors as $errorMessage) {
                        $this->arResult["ERROR_MESSAGE"] .= $errorMessage . ".";
                    }
                }

                $this->includeComponentTemplate();
            }

            $this->arResult = [
                "ID" => $idOrder,
                "ACCOUNT_NUMBER" => $order->getField('ACCOUNT_NUMBER'),
                "URL_TO_DETAIL" => CComponentEngine::MakePathFromTemplate(
                    $this->arParams["PATH_TO_DETAIL"],
                    [
                        "ID" => urlencode(urlencode($order->getField('ACCOUNT_NUMBER')))
                    ]
                ),
                "URL_TO_LIST" => $this->arParams["PATH_TO_LIST"],
            ];
        } catch (Exception $e) {
            throw new Main\SystemException($e);
        }

        $this->includeComponentTemplate();
    }

    /**
     * Function sets page title, if required
     * @param int $idOrder
     * @return void
     */
    protected function setTitle(int $idOrder): void
    {
        global $APPLICATION;
        $APPLICATION->SetTitle(str_replace("#ID#", $idOrder, "Отмена заказа №#ID#"));
    }

    /**
     * @param string $msg
     * @return void
     */
    protected function showMessage(string $msg): void
    {
        $this->arResult["ERROR_MESSAGE"] = $msg;
        $this->includeComponentTemplate();
    }
}