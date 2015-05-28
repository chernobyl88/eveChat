<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class langues extends \Library\Entity {
	protected $id;
	protected $txt_val;
	
	CONST INVALID_ID = 1;
	CONST INVALID_TXT_VAL = 2;

}

?>