<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class ses_ans extends \Library\Entity {
	protected $id;
	protected $date_deb;
	protected $chat_answer_id;
	protected $chat_session_id;
	
	CONST INVALID_ID = 1;
	CONST INVALID_DATE_DEB = 2;
	CONST INVALID_CHAT_ANSWER_ID = 3;
	CONST INVALID_CHAT_SESSION_ID = 4;
}

?>