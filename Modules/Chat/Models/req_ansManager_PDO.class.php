<?php

namespace Modules\Chat\Models;

if (!defined("EVE_APP"))
	exit();

class req_ansManager_PDO extends \Library\Manager_PDO implements req_ansManager {
	function fonctionChelou($int) {
		$sql = "my sql function";
		
		$query = $this->dao->prepare($sql);
		
		$query->execute();
		
		$query->setFetchMode(\PDO::FETCH_ASSOC);
		
		return $query->fetchAll();
	}
	
}

?>