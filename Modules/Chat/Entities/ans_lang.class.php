<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class ans_lang extends \Library\Entity {
	protected $id;
	protected $chat_answer_id;
	protected $langues_id;
	
	CONST INVALID_ID = 1;
	CONST INVALID_CHAT_ANSWER_ID = 2;
	CONST INVALID_LANGUES_ID = 3;

}

?>