<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
class SellerSection extends CBitrixComponent
{
	public function onPrepareComponentParams($arParams): array
	{
		if (!isset($arParams['MAIN_CHAIN_NAME']))
		{
            $arParams['MAIN_CHAIN_NAME'] = 'Кабинет производителя';
		}

		return $arParams;
	}
	public function executeComponent(): void
    {
		$sectionsList = array();

		$this->setFrameMode(false);

		$defaultUrlTemplates404 = array(
			"orders" => "orders/",
			"private" => "private/",
			"index" => "index.php",
			"order_detail" => "orders/#ID#",
			"order_cancel" => "orders/order_cancel.php?ID=#ID#",
		);

		$componentVariables = array("CANCEL", "ID");
		$variables = array();

		$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();

		if ($this->arParams["SEF_MODE"] == "Y")
		{
			$templatesUrls = CComponentEngine::makeComponentUrlTemplates($defaultUrlTemplates404, $this->arParams["SEF_URL_TEMPLATES"]);

			foreach ($templatesUrls as $url => $value)
			{
				$this->arResult["PATH_TO_".ToUpper($url)] = $this->arParams["SEF_FOLDER"].$value;
			}

			$variableAliases = CComponentEngine::makeComponentVariableAliases(array(), $this->arParams["VARIABLE_ALIASES"]);

			$componentPage = CComponentEngine::parseComponentPath(
				$this->arParams["SEF_FOLDER"],
				$templatesUrls,
				$variables
			);

			CComponentEngine::initComponentVariables($componentPage, $componentVariables, $variableAliases, $variables);

			if (empty($componentPage))
			{
				$componentPage = 'index';
			}

			$this->arResult = array_merge(
				Array(
					"SEF_FOLDER" => $this->arParams["SEF_FOLDER"],
					"URL_TEMPLATES" => $templatesUrls,
					"VARIABLES" => $variables,
					"ALIASES" => $variableAliases,
				),
				$this->arResult
			);
		}


		$this->includeComponentTemplate($componentPage);
	}
}