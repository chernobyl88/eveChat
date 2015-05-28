<?php

namespace Library\Models;

if (!defined("EVE_APP"))
	exit();

use Library\Models\userManager;

class userManager_PDO extends \Library\Manager_PDO implements userManager {
	
	public function getList(array $conditions = array()) {
		
		$query = $this->dao->prepare('
				SELECT
					`id`,
					`login`,
					`password`,
					`language`,
					`email`,
					`inscr_date`,
					`civilite`,
					`prenom`,
					`nom`,
					`no_tel`,
					`admin`,
					reference_user,
					prospectus_min_num_id,
					sga_min_num_id
				FROM
					user
				');
		
		$query->execute();

		$query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\user');
		
		$user = $query->fetchAll();
		
		return $user;
		
	}
	
	public function getListSubUser() {
		$query = $this->dao->prepare('
				SELECT
					`id`,
					`login`,
					`password`,
					`language`,
					`email`,
					`inscr_date`,
					`civilite`,
					`prenom`,
					`nom`,
					`no_tel`,
					`admin`,
					reference_user,
					prospectus_min_num_id,
					sga_min_num_id
				FROM
					user
				WHERE
					id NOT IN (
						SELECT
							reference_user
						FROM
							user
					)
				;');
		
		$query->execute();

		$query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\user');
		
		return $query->fetchAll();
	}

	public function get($pId) {
		
		$query = $this->dao->prepare('
				SELECT
					`id`,
					`login`,
					`password`,
					`language`,
					`email`,
					`inscr_date`,
					`civilite`,
					`prenom`,
					`nom`,
					`no_tel`,
					`admin`,
					reference_user,
					prospectus_min_num_id,
					sga_min_num_id
				FROM
					user
				WHERE
					id = :id
				;');
		
		$query->bindValue(':id', $pId, \PDO::PARAM_INT);
		
		$query->execute();

		$query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\user');
		
		$user = $query->fetch();
		if ($user != false) {
			
			return $user;
		} else {
			return new \Library\Entities\user();
		}
		 
	}

	public function getSubUser($pId) {
		
		$query = $this->dao->prepare('
				SELECT
					`id`,
					`login`,
					`password`,
					`language`,
					`email`,
					`inscr_date`,
					`civilite`,
					`prenom`,
					`nom`,
					`no_tel`,
					`admin`,
					reference_user,
					prospectus_min_num_id,
					sga_min_num_id
				FROM
					user
				WHERE
					reference_user = :id
				;');
		
		$query->bindValue(':id', $pId, \PDO::PARAM_INT);
		
		$query->execute();

		$query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\user');
		
		$user = $query->fetchAll();
		
		return $user;
		
	}
	
	public function send(\Library\Entity $pUser) {
		if ($pUser->id() != 0) {
			return $this->update($pUser);
		} else {
			return $this->insert($pUser);
		}
	}
	
	public function insert(\Library\Entity $pUser) {
		$query = $this->dao->prepare("
										SELECT
											count(*) AS nbr
										FROM
											user
										WHERE
											login = :pLogin
									");
		
		$query->bindValue(":pLogin", $pUser->login());
		
		$query->execute();
		
		$info = $query->fetch(\PDO::FETCH_ASSOC);
		
		if ($info["nbr"] != 0) {
			return -1;
		}
		
		$query = $this->dao->prepare('
				INSERT INTO
					user (`id`, `login`, `password`, `language`, `email`, `inscr_date`, `civilite`, `prenom`, `nom`, `no_tel`, `admin`, reference_user, prospectus_min_num_id, sga_min_num_id)
				VALUES (
					null,
					:pLogin,
					:pPassword,
					:pLanguage,
					:pEmail,
					:pInscr_date,
					:pCivilite,
					:pPrenom,
					:pNom,
					:pNoTel,
					:admin,
					:reference_user,
					:sga_min_num_id
				);');

		$query->bindValue(":pLogin", $pUser->login());
		$query->bindValue(":pPassword", $pUser->password());
		$query->bindValue(":pLanguage", $pUser->language());
		$query->bindValue(":pEmail", $pUser->email());
		$query->bindValue(":pInscr_date", \Utils::dateToDb($pUser->inscr_date()));
		$query->bindValue(":pCivilite", $pUser->civilite());
		$query->bindValue(":pPrenom", $pUser->prenom());
		$query->bindValue(":pNom", $pUser->nom());
		$query->bindValue(":pNoTel", $pUser->no_tel());
		$query->bindValue(":admin", $pUser->admin());
		$query->bindValue(":reference_user", $pUser->reference_user());
		$query->bindValue(":prospectus_min_num_id", $pUser->prospectus_min_num_id());
		$query->bindValue(":sga_min_num_id", $pUser->sga_min_num_id());
		
		if ($query->execute()) {
			$pUser->setId($this->dao->lastInsertId());
			
			$listeAdresse = $pUser->listAdresse();
			
			foreach ($listeAdresse AS $adresse) {
				$this->sendAdresse($adresse);
			}
			
			return $pUser;
		} else {
			return -2;
		}
	}
	
	public function update(\Library\Entity $pUser) {
		$query = $this->dao->prepare("
										SELECT
											count(*) AS nbr
										FROM
											user
										WHERE
											login = :pLogin
										AND
											id != :pId
									");

		$query->bindValue(":pLogin", $pUser->login());
		$query->bindValue(":pId", $pUser->id(), \PDO::PARAM_INT);
		
		$query->execute();
		
		$info = $query->fetch(\PDO::FETCH_ASSOC);
		
		if ($info["nbr"] != 0) {
			return -1;
		}
		
		$query = $this->dao->prepare('
				UPDATE
					user
				SET
					 `login` = :pLogin,
					 `password` = :pPassword,
					 `language` = :pLanguage,
					 `email` = :pEmail,
					 `inscr_date` = :pInscr_date,
					 `civilite` = :pCivilite,
					 `prenom` = :pPrenom,
					 `nom` = :pNom,
					 `no_tel` = :pNoTel,
					 `admin` = :admin,
					  reference_user = :reference_user,
					  prospectus_min_num_id = :prospectus_min_num_id,
					 sga_min_num_id = :sga_min_num_id
				WHERE
					 `id` = :pId
				;');

		$query->bindValue(":pId", $pUser->id());
		$query->bindValue(":pLogin", $pUser->login());
		$query->bindValue(":pPassword", $pUser->password());
		$query->bindValue(":pLanguage", $pUser->language());
		$query->bindValue(":pEmail", $pUser->email());
		$query->bindValue(":pInscr_date", \Utils::dateToDb($pUser->inscr_date()));
		$query->bindValue(":pCivilite", $pUser->civilite());
		$query->bindValue(":pPrenom", $pUser->prenom());
		$query->bindValue(":pNom", $pUser->nom());
		$query->bindValue(":pNoTel", $pUser->no_tel());
		$query->bindValue(":admin", $pUser->admin());
		$query->bindValue(":reference_user", $pUser->reference_user());
		$query->bindValue(":prospectus_min_num_id", $pUser->prospectus_min_num_id());
		$query->bindValue(":sga_min_num_id", $pUser->sga_min_num_id());
		
		if ($query->execute()) {
			
			$listeAdresse = $pUser->listAdresse();
			
			foreach ($listeAdresse AS $adresse) {
				$this->sendAdresse($adresse);
			}
			
			return $pUser;
		} else {
			return -2;
		}
	}
	
	public function getUserForOptionForUser($pId) {
		$query = $this->dao->prepare("
				SELECT
					id AS `KEY`,
					CONCAT(nom, ' ', prenom) AS `VALUE`
				FROM
					user
				WHERE
					id = :user_id
				OR
					reference_user = :user_id
				;");
		
		$query->bindValue(":user_id", $pId, \PDO::PARAM_INT);
		
		if ($query->execute()) {
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			return array();
		}
	}
}

?>