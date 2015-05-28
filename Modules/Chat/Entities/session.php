<?php

namespace Modules\Chat\Entities;

if (!defined("EVE_APP"))
	exit();

class session extends \Library\Entity {
	protected $id;
	protected $chat_request_id;
	protected $politesse;
	protected $qualite;
	protected $reponse;
	protected $date_deb;
	protected $date_fin;
	protected $chat_user_id;
	
	CONST INVALID_ID = 1;
	CONST INVALID_CHAT_REQUEST_ID =2;
	CONST INVALID_DATE_DEB = 3;
	CONST INVALID_DATE_FIN = 4;
	CONST INVALID_CHAT_USER_ID = 5;
}

?>