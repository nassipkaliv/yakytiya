<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if ($arResult["isFormErrors"] == "Y") {
	echo $arResult["FORM_ERRORS_TEXT"];
}
echo $arResult["FORM_NOTE"];
if ($arResult["isFormNote"] != "Y") {
	?>
	<?=$arResult["FORM_HEADER"]?>
	<table>
		<?
		if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y") {
		?>
			<tr>
				<td><?
					if ($arResult["isFormTitle"]) {
						?><h3><?=$arResult["FORM_TITLE"]?></h3><?
					}

					if ($arResult["isFormImage"] == "Y") {
					?>
						<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
						<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
						<?
					}
					?>

					<p><?=$arResult["FORM_DESCRIPTION"]?></p>
				</td>
			</tr>
			<?
		}
		?>
	</table>
	<br />
	<table class="form-table data-table">
		<thead>
			<tr>
				<th colspan="2">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?
		foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
			if ($arQuestion['CAPTION'] == 'id туристического товара') {
				echo '<input type="hidden"  class="inputtext"  name="form_text_1" value="' . $arParams['ELEMENT_ID'] . '">';
			} else {
				if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') {
					echo $arQuestion["HTML_CODE"];
				} else {
				?>
					<tr>
						<td>
							<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])) {
								echo '<span class="error-fld" title="' . htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID]) .'"></span>';
							}
							echo $arQuestion["CAPTION"];
							if ($arQuestion["REQUIRED"] == "Y") {
								echo $arResult["REQUIRED_SIGN"];
							}
							echo $arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : "";
							?>
						</td>
						<td><?=$arQuestion["HTML_CODE"]?></td>
					</tr>
				<?
				}
			}
		}
		?>
	<?
	if ($arResult["isUseCaptcha"] == "Y") {
	?>
		<tr>
			<th colspan="2"><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b></th>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
		</tr>
		<tr>
			<td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></td>
			<td><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
		</tr>
	<?
	}
	?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2">
					<input type="hidden" name="web_form_apply" value="Y" />
					<input type="submit" class="js-tourism-order-submit btn btn-primary" name="web_form_apply" value="Забронировать" />
				</th>
			</tr>
		</tfoot>
	</table>
	<p>
	<?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
	</p>
	<?=$arResult["FORM_FOOTER"]?>
	<?
} //endif (isFormNote)