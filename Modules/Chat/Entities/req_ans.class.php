<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class req_ans extends \Library\Entity {
	protected $id;
	protected $chat_answer_id;
	protected $chat_request_id;
	protected $date_deb;

	
	CONST INVALID_ID = 1;
	CONST INVALID_CHAT_ANSWER_ID = 2;
	CONST INVALID_CHAT_REQUEST_ID = 3;
	CONST INVALID_DATE_DEB = 4;

}	

?>