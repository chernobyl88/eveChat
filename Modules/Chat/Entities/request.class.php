<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class request extends \Library\Entity {
	protected $id;
	protected $cst_type;
	protected $date_add;
	
	CONST INVALID_ID = 1;
	CONST INVALID_CST_TYPE = 2;
	CONST INVALID_DATE_ADD = 3;
}

?>