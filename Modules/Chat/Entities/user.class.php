<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class user	 extends \Library\Entity {
	protected $id;
	protected $mail;
	protected $ip;
	
	CONST INVALID_ID = 1;
	CONST INVALID_MAIL = 2;
	CONST INVALID_IP = 3;

}

?>