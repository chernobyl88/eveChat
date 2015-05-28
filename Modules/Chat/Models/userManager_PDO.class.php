<?php

namespace Modules\Chat\Models;

if (!defined("EVE_APP"))
	exit();

class userManager_PDO extends \Library\Manager_PDO implements userManager {
	function fonctionChelou($int) {
		$sql = "my sql function";
		
		$query = $this->dao->prepare($sql);
		
		$query->execute();
		
		$query->setFetchMode(\PDO::FETCH_ASSOC);
		
		return $query->fetchAll();
	}
	
}

?>