<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class blocban extends \Library\Entity {
	protected $id;
	protected $is_ban;
	protected $chat_session_id;
	protected $date_block;
	protected $tech_message;
	
	CONST INVALID_ID = 1;
	CONST INVALID_IS_BAN = 2;
	CONST INVALID_CHAT_SESSION_ID = 3;
	CONST INVALID_DATE_BLOCK = 4;
	CONST INVALID_TECH_MESSGE = 5;

}

?>