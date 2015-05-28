<?php

namespace Modules\Chat\Models;

if (!defined("EVE_APP"))
	exit();

class answerManager_PDO extends \Library\Manager_PDO implements answerManager {
	public function getListTechDispoId($pLang, $pRequest) {
		if (!(is_numeric($pLang) && is_numeric($pRequest)))
			return array();
		
		$sql = "
		SELECT
			ca.`" . implode("`, ca.`", array_keys($this->listeElem)) . "`
		FROM
			chat_answer ca
		INNER JOIN
			chat_ans_lang cal
		ON
			cal.chat_ans_id = ca.id
		INNER JOIN
			chat_req_ans cra
		ON
			ca.id = cra.chat_answer_id 
		WHERE
			cal.langues_id  = :pLang
		AND
			cra.chat_request_id = :pRequest
		AND
			ca.date_fin IS NULL
		AND
			ca.nbr_max > (
					SELECT
						COUNT(*)
					FROM
						chat_ses_ans csa
					WHERE
						csa.chat_answer_id = ca.id
					)
		;";
		
		$query = $this->dao->prepare($sql);

		$query->bindValue(':pLang', $pLang, \PDO::PARAM_INT);
		$query->bindValue(':pRequest', $pRequest, \PDO::PARAM_INT);
		
		$query->execute();
		
		$query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "\Modules\Chat\Entities\answer");
		
		return $query->fetchAll();
	}
}

?>