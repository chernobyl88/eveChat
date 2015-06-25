<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class message extends \Library\Entity {
	protected $id;
	protected $message;
	protected $chat_session;
	protected $date_mess;
	protected $chat_user;
	protected $user_id;
	
	CONST INVALID_ID = 1;
	CONST INVALID_CHAT_SESSION = 2;
	CONST INVALID_DATE_MESS = 3;
	CONST INVALID_MESSAGE = 6;
}

?>