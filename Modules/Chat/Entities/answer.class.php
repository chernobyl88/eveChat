<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class answer extends \Library\Entity {
	protected $id;
	protected $user_id;
	protected $date_deb;
	protected $date_fin;
	protected $nbr_max;
	
	CONST INVALID_ID = 1;
	CONST INVALID_USER_ID = 2;
	CONST INVALID_DATE_DEB = 3;
	CONST INVALID_DATE_FIN = 4;
	CONST INVALID_NBR_MAX = 5;
}

?>