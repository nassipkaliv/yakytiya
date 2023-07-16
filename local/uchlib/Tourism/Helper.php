<?php
use Bitrix\Sale\Internals\DiscountTable;

class CU_Tourism_Helper
{
	public static function test() {
		echo '111111';
	}

	/*public static function printTourismBuyModalActivation()
	{
		?>
		<span data-toggle="modal" data-target="#tourism-buy">Забронировать</span>
		<?php
	}*/

	public static function printTourismBuyModalActivation($elementId)
	{
		?>
		<br>
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
			Забронировать
		</button>
		<div class="modal" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalCenterTitle">Форма бронирования</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>

					<div class="modal-body">
						<p>Веб форма для заявки на туризм</p>
						<?

							global $APPLICATION;
							$APPLICATION->IncludeComponent(
								"bitrix:form.result.new",
								"tourism-order",
								Array(
									"SEF_MODE" => "N",
									"WEB_FORM_ID" => "1", //
									"LIST_URL" => "",
									"EDIT_URL" => "/tourism/success.php",
									"SUCCESS_URL" => "",
									"CHAIN_ITEM_TEXT" => "",
									"CHAIN_ITEM_LINK" => "",
									"IGNORE_CUSTOM_TEMPLATE" => "N",
									"USE_EXTENDED_ERRORS" => "Y",
//									"CACHE_TYPE" => "A",
//									"CACHE_TIME" => "3600",
									"VARIABLE_ALIASES" => Array(
										"WEB_FORM_ID" => "WEB_FORM_ID",
										"RESULT_ID" => "RESULT_ID"
									),
									'ELEMENT_ID' => $elementId
								),
							false
							);
						?>
					</div>

<!--					<div class="modal-footer">-->
<!--					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>-->
<!--						<button type="button" class="btn btn-primary">Забронировать</button>-->
<!--					</div>-->
				</div>
			</div>
		</div>
		<?php
	}

	/*public static function printTourismBuyModal()
	{
		?>
		<div class="modal fade init" tabindex="-1" role="dialog" id="tourism-buy" style="display: none;">
		<div class="modal-dialog modal-sm" role="document">

			<div class="modal-content" style="">
				<div class="modal-header modal-header-success">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="fum fum-close" aria-hidden="true"></span></button>
					<div class="modal-title">Коммерческое предложение</div>
				</div>
				<div class="modal-body">
					<div class="commerce-menu-wrapper"><div class="mbl"><div>Вам могут быть отправлены несколько коммерческих предложений. Для этого заполните эту форму и нажмите кнопку "Отправить".</div>
						</div><form action="" method="POST" id="commerce-menu" enctype="multipart/form-data">		<div class="form-group ">
								<label for="form_text_7176">Имя <span class="text-danger">*</span></label><input type="text" name="form_text_7176" class="form-control" value="Евгений Шапочкин">		</div>
							<div class="form-group ">
								<label for="form_text_7177">Телефон <span class="text-danger">*</span></label><input type="text" name="form_text_7177" class="form-control" value="">		</div>
							<div class="form-group ">
								<label for="form_email_7179">E-mail <span class="text-danger">*</span></label><input type="text" name="form_email_7179" class="form-control" value="shapochkin.evgeniy@uchitel-izd.ru">		</div>
							<div class="form-group ">
								<label for="form_text_7180">Количество предложений</label><input type="text" name="form_text_7180" class="form-control" value="">		</div>
							<div class="form-group ">
								<label for="form_file_7182">Карточка предприятия</label><input type="file" name="form_file_7182" class="form-control">		</div>
							<div class="form-group ">
								<label for="form_textarea_7183">Комментарий</label><textarea name="form_textarea_7183" class="form-control"></textarea>		</div>
							<input type="hidden" name="form_hidden_7184" value="/local/components/intervolga/zend.web-forms/ajax.php"><input type="hidden" name="WEB_FORM_ID" value="47"><input type="hidden" name="FORM_ID" value="commerce-menu">		<div class="form-group ">
								<label for="captcha">Введите символы с картинки <span class="text-danger">*</span></label>		<div class="clearfix form-captcha">
									<div class="pull-left captcha-img">
										<img class="form-control-captcha" src="/bitrix/tools/captcha.php?captcha_sid=0f809427792b09849d2bf2fefd35775d">			</div>
									<div class="pull-right captcha-input">
										<input type="hidden" name="captcha_code" value="0f809427792b09849d2bf2fefd35775d"><input name="captcha" class="form-control" type="text" value="">			</div>
								</div>
							</div>
							<button type="submit" name="submit" id="submitbutton" class="btn btn-primary btn-lg" value="Отправить">Отправить</button></form></div>
				</div>
				<div id="commerce-menu-close-wrap" style="display: none;">
					<div class="modal-footer">
						<button id="commerce-menu-close" class="btn btn-primary center-block" data-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</div>
		</div>
	</div>
		<?php
	}*/

	public static function printTourismBuyModal()
	{
		?>
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-4">.col-md-4</div>
								<div class="col-md-4 ms-auto">.col-md-4 .ms-auto</div>
							</div>
							<div class="row">
								<div class="col-md-3 ms-auto">.col-md-3 .ms-auto</div>
								<div class="col-md-2 ms-auto">.col-md-2 .ms-auto</div>
							</div>
							<div class="row">
								<div class="col-md-6 ms-auto">.col-md-6 .ms-auto</div>
							</div>
							<div class="row">
								<div class="col-sm-9">
									Level 1: .col-sm-9
									<div class="row">
										<div class="col-8 col-sm-6">
											Level 2: .col-8 .col-sm-6
										</div>
										<div class="col-4 col-sm-6">
											Level 2: .col-4 .col-sm-6
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}