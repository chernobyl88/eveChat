<?php

namespace Modules\Chat\Models;

if (!defined("EVE_APP"))
	exit();

class requestManager_PDO extends \Library\Manager_PDO implements requestManager {
	function getListUsedRequest($lang) {
		$sql = "
		SELECT
			DISTINCT(cr.id) AS id,
			cr.cst_type AS cst_type
		FROM
			chat_request cr
		INNER JOIN
			chat_req_ans cra
		ON
			cra.chat_request_id = cr.id
		INNER JOIN
			chat_answer ca
		ON
			ca.id = cra.chat_answer_id
		INNER JOIN
			chat_ans_lang cal
		ON
			cal.chat_answer_id = ca.id
		INNER JOIN
			chat_langues cl
		ON
			cl.id = cal.langues_id
		WHERE
			ca.date_fin IS NULL
		AND
			cl.txt_val = :pLang
		;";
		
		$query = $this->dao->prepare($sql);
		
		$query->bindValue(":pLang", \Utils::getFormatLanguage($lang), \PDO::PARAM_STR);
		
		$query->execute();
		
		return $query->fetchAll(\PDO::FETCH_ASSOC);
	}
}

?>