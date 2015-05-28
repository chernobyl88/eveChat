<?php

namespace Library\Entities;

if (!defined("EVE_APP"))
	exit();

use Library\Entity;

class adresse extends Entity {
	protected $id;
	protected $user_id;
	protected $titre;
	protected $entreprise;
	protected $adresse;
	protected $case_postale;
	protected $localite;
	
	protected $prenom;
	protected $nom;
	
	const INVALID_ID = 1;
	const INVALID_USER_ID = 2;
	const INVALID_ENTREPRISE = 5;
	const INVALID_ADRESSE = 8;
	const INVALID_LOCALITE = 9;
	
	const INVALID_NOM = 3;
	const INVALID_PRENOM = 4;
	
	public function __construct($pArg = array()){
		$this->hydrate($pArg);
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
	
	public function user_id() {
		if (isset($this->user_id)) {
			return $this->user_id;
		} else {
			return 0;
		}
	}
	
	public function setUser_id($pVal) {
		if (is_numeric($pVal) && !empty($pVal)) {
			$this->user_id = $pVal;
			return 1;
		}
		
		$this->setError(self::INVALID_USER_ID);
		return 0;
	}
	
	public function entreprise() {
		if (isset($this->entreprise)) {
			return $this->entreprise;
		} else {
			return "";
		}
	}
	
	public function setEntreprise($pVal) {
		$this->entreprise = \Utils::protect($pVal);
		return 1;
	}
	
	public function adresse() {
		if (isset($this->adresse)) {
			return $this->adresse;
		} else {
			return "";
		}
	}
	
	public function setAdresse($pVal) {
		if (is_string($pVal) && !empty($pVal)) {
			$this->adresse = \Utils::protect($pVal);
			return 1;
		}
		$this->setError(self::INVALID_ADRESSE);
		return 0;
	}
	
	public function case_postale() {
		if (isset($this->case_postale)) {
			if (is_numeric($this->case_postale)) {
				return "Case Postale " . $this->case_postale;
			} elseif (is_string($this->case_postale)) {
				return $this->case_postale;
			} else {
				return "";
			}
		} else {
			return "";
		}
	}
	
	public function setCase_postale($pVal) {
		$this->case_postale = \Utils::protect($pVal);
		return 1;
	}
	
	public function localite() {
		if (isset($this->localite)) {
			return $this->localite;
		} else {
			return "";
		}
	}
	
	public function setLocalite($pVal) {
		if (is_string($pVal) && !empty($pVal)) {
			$this->localite = \Utils::protect($pVal);
			return 1;
		}
		$this->setError(self::INVALID_LOCALITE);
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
	
	public function setTitre($pVal) {
		switch ($pVal) {
			case "M":
			case "Mme":
				$this->titre = $pVal;
				break;
			default:
				$this->titre = "M";
		}
		return 1;
	}
	
	public function titre() {
		switch ($this->titre) {
			case "M":
			case "Mme":
				if (defined(strtoupper("TITRE_".$this->titre))) {
					return constant(strtoupper("TITRE_".$this->titre));
				} else {
					return $this->titre;
				}
				break;
			default:
				if (defined(strtoupper("TITRE_M"))) {
					return constant(strtoupper("TITRE_M"));
				} else {
					return "M";
				}
				
		}
	}
	
	public function __toString(){
		$ret = '<div class="adresse">';

			if (isset($this->entreprise)) {
				$ret .= "<div>" . $this->entreprise . "</div>";
			}
			
			if (isset($this->titre) && isset($this->nom) && isset($this->prenom)) {
				$ret .= "<div>" . $this->titre() . " " . $this->prenom . " " . $this->nom . "</div>";
			} elseif (isset($this->nom) && isset($this->prenom)) {
				$ret .= "<div>" . $this->prenom . " " . $this->nom . "</div>";
			}
			
			if (isset($this->adresse) && !empty($this->adresse)) {
				$ret .= "<div>" . $this->adresse . "</div>";
			}
			if (isset($this->case_postale) && !empty($this->case_postale)) {
				$ret .= "<div>" . $this->case_postale . "</div>";
			}
			if (isset($this->localite) && !empty($this->localite)) {
				$ret .= "<div>" . $this->localite . "</div>";
			}
		
		$ret .= '</div>';
		
		return $ret;
	}
	
	public function setInfoFromUser(\Library\Entities\User $pUser) {
		$this->setNom($pUser->nom());
		$this->setPrenom($pUser->prenom());
		$this->setTitre($pUser->civilite());
		$this->setUser_id($pUser->id());
		
		return 1;
	}
}

?>