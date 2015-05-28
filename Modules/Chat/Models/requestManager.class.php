<?php

namespace Modules\Chat\Models;

if (!defined("EVE_APP"))
	exit();

interface requestManager {
	function getListUsedRequest($lang);
}

?>