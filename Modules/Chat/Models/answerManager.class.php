<?php

namespace Modules\Chat\Models;

if (!defined("EVE_APP"))
	exit();

interface answerManager {
	function getListTechDispoId($pLang, $pRequest);
}

?>