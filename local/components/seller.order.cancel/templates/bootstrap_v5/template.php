<?php
global $arResult;
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>
<div class="row mb-3">
    <div class="col">
        <a href="<?= $arResult["URL_TO_LIST"] ?>">В список заказов</a>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="bx-order-cancel">
            <?php
            if ($arResult["ERROR_MESSAGE"] == ''): ?>
                <form method="post" action="<?= POST_FORM_ACTION_URI ?>">
                    <input type="hidden" name="CANCEL" value="Y">
                    <?= bitrix_sessid_post() ?>
                    <input type="hidden" name="ID" value="<?= $arResult["ID"] ?>">

                    <p class="mb-2">
                        Вы уверены, что хотите отменить
                        <a href="<?= $arResult["URL_TO_DETAIL"] ?>">заказ #<?= $arResult["ACCOUNT_NUMBER"] ?></a>?
                    </p>

                    <p class="mb-3">
                        <strong class="text-danger">Отмена заказа необратима.</strong>
                    </p>

                    <div class="form-group">
                        <label for="orderCancel">Укажите, пожалуйста, причину отмены заказа</label>
                        <textarea name="REASON_CANCELED" class="form-control" id="orderCancel" rows="3"></textarea>
                    </div>

                    <input type="submit" name="action" class="btn btn-danger" value="Отменить заказ">
                    <a href="<?= $arResult["URL_TO_LIST"] ?>" class="btn btn-link">В список заказов</a>
                </form>
            <?php
            else: ?>
                <?= ShowError($arResult["ERROR_MESSAGE"]); ?>
            <?php
            endif; ?>
        </div>
    </div>
</div>