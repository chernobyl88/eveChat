<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class waiting extends \Library\Entity {
	protected $id;
	protected $chat_session_id;
	protected $date_deb;
	protected $date_fin;
	protected $last_check;
	
	CONST INVALID_ID = 1;
	CONST INVALID_CHAT_SESSION_ID = 2;
	CONST INVALID_DATE_DEB = 3;
	CONST INVALID_DATE_FIN = 4;
	CONST INVALID_LAST_CHECK = 5;
}

?>