<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class pleinte extends \Library\Entity {
	protected $id;
	protected $pleinte_message;
	protected $date_send;
	protected $chat_session_id;

	
	CONST INVALID_ID = 1;
	CONST INVALID_PLEINTE_MESSAGE = 2;
	CONST INVALID_DATE_SEND = 3;
	CONST INVALID_CHAT_SESSION_ID = 4;
}

?>