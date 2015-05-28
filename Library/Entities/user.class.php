<?php

namespace Library\Entities;

if (!defined("EVE_APP"))
	exit();

use Library\Entity;

class user extends Entity {
	protected $id;
	protected $login;
	protected $password;
	protected $language;
	protected $email;
	protected $inscr_date;
	protected $civilite;
	protected $prenom;
	protected $nom;
	protected $no_tel;
	protected $password_conf;
	protected $admin;
	protected $reference_user;
	protected $prospectus_min_num_id;
	protected $sga_min_num_id;
	protected $listAdresse = array();
	
	protected $modif_pass;
	
	const INVALID_ID = 1;
	const INVALID_PASSWORD = 2;
	const INVALID_LOGIN = 10;
	const INVALID_LANGUAGE = 3;
	const INVALID_EMAIL = 4;
	const INVALID_ENTREPRISE = 5;
	const INVALID_PRENOM = 6;
	const INVALID_NOM = 7;
	const INVALID_ADRESSE = 8;
	const INVALID_LOCALITE = 9;
	
	public function sga_min_num_id() {
		if (isset($this->sga_min_num_id)) {
			return $this->sga_min_num_id;
		} else {
			return 0;
		}
	}
	
	public function setSga_min_num_id($pVal) {
		if (is_numeric($pVal) && !empty($pVal) && $pVal > 0) {
			$this->sga_min_num_id = $pVal;
		} else {
			$this->sga_min_num_id = 0;
		}

		return 1;
	}
	
	public function prospectus_min_num_id() {
		if (isset($this->prospectus_min_num_id)) {
			return $this->prospectus_min_num_id;
		} else {
			return 0;
		}
	}
	
	public function setProspectus_min_num_id($pVal) {
		
		if (is_numeric($pVal) && !empty($pVal) && $pVal > 0) {
			$this->prospectus_min_num_id = $pVal;
		} else {
			$this->prospectus_min_num_id = 0;
		}

		return 1;
	}
	
	public function id() {
		if (isset($this->id)) {
			return $this->id;
		} else {
			return 0;
		}
	}
	
	public function setId($pVal) {
		
		if (is_numeric($pVal) && !empty($pVal)) {
			$this->id = $pVal;
		} else {
			$this->id = null;
		}

		return 1;
	}
	
	public function setLogin($pVal) {
		if (is_string($pVal) && !empty($pVal)) {
			$this->login = \Utils::protect($pVal);
			return 1;
		}

		$this->setError(self::INVALID_LOGIN);
		return 0;
	}
	
	public function login() {
		if (isset($this->login)) {
			return $this->login;
		} else {
			return "";
		}
	}
	
	public function setPassword($pVal) {
		if (is_string($pVal) && !empty($pVal)) {
			$this->password = \Utils::hash($pVal, \Utils::getBlowfishSalt());
			$this->modif_pass = 1;
		} else {
			$this->modif_pass = 0;
		}
		return 1;
	}
	
	public function password() {
		return $this->password;
	}
	
	public function setPassword_conf($pVal) {
		if($this->modif_pass){
			if (\Utils::hash($pVal, $this->password) == $this->password) {
				return 1;
			} else {
				$this->setError(self::INVALID_PASSWORD);
				return 0;
			}
		}
	}
	
	public function password_conf() {
		return "";
	}
	
	public function language() {
		if (isset($this->language)) {
			return $this->language;
		} else {
			return \Utils::defaultLanguage();
		}
	}
	
	public function setLanguage($pVal) {
		if (is_string($pVal) && !empty($pVal)) {
			$this->language = \Utils::getFormatLanguage($pVal);
			return 1;
		}
		$this->setError(self::INVALID_LANGUAGE);
		return 0;
	}
	
	public function email() {
		if (isset($this->email)) {
			return $this->email;
		} else {
			return "";
		}
	}
	
	public function setEmail($pVal) {
		if (\Utils::testEmail($pVal)) {
			$this->email = $pVal;
			return 1;
		}
		$this->setError(self::INVALID_EMAIL);
		return 0;
	}
	
	public function inscr_date() {
		if (isset($this->inscr_date)) {
			if (!($this->inscr_date instanceof \DateTime)) {
				$this->inscr_date = new \DateTime($this->inscr_date);
			}
			return $this->inscr_date;
		} else {
			return new \DateTime();
		}
	}
	
	public function setInscr_date() {
		if(is_array($pVal)){
			global $app;
			$langFormat = \Utils::getDateFormat($app->httpRequest()->languageGet());
			$date = $pVal[0].'-'.$pVal[1].'-'.$pVal[2];
				
			if(preg_match('/'.$langFormat[2].'/', $date)){
				$this->inscr_date = \DateTime::createFromFormat($langFormat[1], $date);
			} else {
				$this->setError(self::INVALID_INSCR_DATE);
				return 0;
			}
		}else if($pVal instanceof \DateTime){
			$this->inscr_date = $pVal;
		}else if(is_string($pVal)){
			$this->inscr_date = new \DateTime($pVal);
		} else {
			$this->setError(self::INVALID_INSCR_DATE);
			return 0;
		}
		
		return 1;
	}
	
	public function entreprise($pUser = 0) {
		if ($pUser >= 0 && $pUser < count($this->listAdresse)) {
			return $this->listAdresse[$pUser]->entreprise();
		} else {
			return "";
		}
	}
	
	public function civilite() {
		if (isset($this->civilite)) {
			return $this->civilite;
		} else {
			return 'M.';
		}
	}
	
	public function setCivilite($pVal) {
		switch($pVal) {
			case 'Mme.':
			case 'M.':
			case 'Mlle.':
				$this->civilite = $pVal;
			default:
				$this->civilite = $pVal;
		}
		return 1;
	}
	
	
	public function prenom() {
		if (isset($this->prenom)) {
			return $this->prenom;
		} else {
			return "";
		}
	}
	
	public function setPrenom($pVal) {
		if (is_string($pVal) && !empty($pVal)) {
			$this->prenom = \Utils::protect($pVal);
			return 1;
		}
		$this->setError(self::INVALID_PRENOM);
		return 0;
	}
	
	public function nom() {
		if (isset($this->nom)) {
			return $this->nom;
		} else {
			return "";
		}
	}
	
	public function setNom($pVal) {
		if (is_string($pVal) && !empty($pVal)) {
			$this->nom = \Utils::protect($pVal);
			return 1;
		}
		$this->setError(self::INVALID_NOM);
		return 0;
	}
	
	public function adresse($pUser = 0) {
		if ($pUser >= 0 && $pUser < count($this->listAdresse)) {
			return $this->listAdresse[$pUser]->adresse();
		} else {
			return "";
		}
	}
	
	public function case_postale($pUser = 0) {
		if ($pUser >= 0 && $pUser < count($this->listAdresse)) {
			return $this->listAdresse[$pUser]->case_postale();
		} else {
			return "";
		}
	}
	
	public function localite($pUser = 0) {
		if ($pUser >= 0 && $pUser < count($this->listAdresse)) {
			return $this->listAdresse[$pUser]->localite();
		} else {
			return "";
		}
	}
	
	public function no_tel() {
		if (isset($this->no_tel)) {
			return $this->no_tel;
		} else {
			return "";
		}
	}
	
	public function setNo_tel($pVal) {
		$this->no_tel = \Utils::protect($pVal);
		return 1;
	}
	
	public function admin() {
		if (isset($this->admin)) {
			return $this->admin;
		} else {
			return 0;
		}
	}
	
	public function setAdmin($pVal) {
		switch ($pVal) {
			case 0:
			case 1:
				$this->admin = $pVal;
				break;
			default:
				$this->admin = 0;
		}
		return 1;
	}
	
	public function reference_user() {
		if (isset($this->reference_user)) {
			return $this->reference_user;
		} else {
			return -1;
		}
	}
	
	public function setReference_user($pVal) {
		if (is_numeric($pVal) && !empty($pVal)) {
			$this->reference_user = $pVal;
		}
		
		return 1;
	}
	
	public function setListeAdresse(array $lAdresse) {
		foreach ($lAdresse AS $adresse) {
			$this->addAdresse($adresse);
		}
	}
	
	public function addAdresse(\Library\Entities\Adresse $adresse) {
		$this->listAdresse[] = $adresse;
	}
	
	public function listAdresse() {
		return $this->getListAdresse();
	}
	
	public function getListAdresse($pKey = -1) {
		if ($pKey < 0) {
			return $this->listAdresse;
		} else if($pKey < count($this->listAdresse)) {
			return $this->listAdresse[$pKey];
		} else {
			return new \Library\Entities\Adresse();
		}
	}
	
	public function setAdresse(\Library\Entities\Adresse $adresse, $key = -1) {
		
		if (!array_key_exists($key, $this->listAdresse)) {
			$this->addAdresse($adresse);
		} else {
			$this->listAdresse[$key] = $adresse;
		}
	}
}

?>