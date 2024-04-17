<?php

use Bitrix\Main\Error;
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Engine\Contract\Controllerable;
use CBitrixComponent;

if (
	!defined("B_PROLOG_INCLUDED") 
	|| B_PROLOG_INCLUDED !== true
) {
	die();
}

class LikesITC extends CBitrixComponent implements Controllerable, Errorable
{
	protected ErrorCollection $errorCollection;

	public function configureActions()
    {
        return [
            'setLikes' => [
                'prefilters' => [],
            ]
        ];
    }

	public function onPrepareComponentParams($arParams)
    {
        $this->errorCollection = new ErrorCollection();
		return $arParams;
    }

	public function executeComponent()
	{
		try {
			$this->arResult = $this->getResult();
			$this->IncludeComponentTemplate();

		} catch (SystemException $e) {
			ShowError($e->getMessage());
		}
	}

	//в параметр $person будут автоматически подставлены данные из REQUEST
    public function setLikesAction($id, $type, $cookieName)
    {
        try {
            $count = $this->setLikeType($id, $type, $cookieName);

            return $count;
        } catch (Exceptions\EmptyEmail $e) {
            $this->errorCollection[] = new Error($e->getMessage());
            return [
                "result" => "Произошла ошибка",
            ];
        }
    }

	/**
     * Getting array of errors.
     * @return Error[]
     */
    public function getErrors()
    {
        return $this->errorCollection->toArray();
    }

    /**
     * Getting once error with the necessary code.
     * @param string $code Code of error.
     * @return Error
     */
    public function getErrorByCode($code)
    {
        return $this->errorCollection->getErrorByCode($code);
    }

	public function getResult() {
		$arLikes = [];
		$table = $this->getTable($this->arParams['ID']);

		if ($table) {
			$arElements = $table::getList([
				'select' => [
					'ID', 
					'NAME',
					'LIKE_VALUE' => 'LIKE.VALUE',
					'DISLIKE_VALUE' => 'DISLIKE.VALUE',
				],
				'filter' => [
					'ACTIVE' => 'Y',
					'ID' => $this->arParams['ID'],
				],
			]);
			
			if ($arElement = $arElements->fetch()) {
				$arLikes = [
					'ID' => $arElement['ID'],
					'LIKE' => intval($arElement['LIKE_VALUE']),
					'DISLIKE' => intval($arElement['DISLIKE_VALUE']),
				];
			}
		}

		return $arLikes;
	}

	public function setLikeType($id, $type,  $cookieName) {
		\Bitrix\Main\Loader::includeModule('iblock');

		$codeProps = strtoupper($type);
		$table = $this->getTable($id);
		$count = NULL;

		$element = $table::getByPrimary(
			$id, 
			[
				'select' => [
					"{$codeProps}_VALUE"  => "{$codeProps}.VALUE"
				]
			]
		);

		if ($prop = $element->fetch()) {
			$count = (int) $prop["{$codeProps}_VALUE"];
		}

		$count += 1;

		CIBlockElement::SetPropertyValuesEx($id, false, [$codeProps => $count]);
		
		$this->setCookie($type, $cookieName, $id);

		return $count;
	}

	private function setCookie($codeProps, $cookieName, $id) {
		$cookie = new \Bitrix\Main\Web\Cookie("{$cookieName}_{$id}", $codeProps, time() + (10 * 365 * 24 * 60 * 60));
		$cookie->setSpread(\Bitrix\Main\Web\Cookie::SPREAD_DOMAIN);
		$cookie->setDomain(SITE_SERVER_NAME); // домен
		$cookie->setPath("/");
		$cookie->setSecure(false);
		$cookie->setHttpOnly(false);

		\Bitrix\Main\Application::getInstance()->getContext()->getResponse()->addCookie($cookie);
	}

	private function getTable($id) {
		$iblock = CIBlockElement::GetIBlockByID($id);
		return \Bitrix\Iblock\Iblock::wakeUp($iblock)->getEntityDataClass();
	}
	
}


