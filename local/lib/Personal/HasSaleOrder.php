<?php
namespace lib\Personal;

trait HasSaleOrder
{

    /**
     * @param $idUserOrder
     * @return bool
     */
	function isOrderBelongsToUser($idUserOrder): bool {
		global $USER;
		return $idUserOrder !== $USER->GetID();
	}
}