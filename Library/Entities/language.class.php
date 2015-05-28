<?php

namespace Library\Entities;

if (!defined("EVE_APP"))
	exit();

class language extends \Library\Entity{
	protected $id;
	protected $clef;
	protected $valeur;
	protected $lang;

	CONST INVALID_ID = 1;
	CONST INVALID_CLEF = 1;
	CONST INVALID_VALEUR = 2;
	CONST INVALID_LANG = 3;
	
	public function setId($pVal){
		if(!is_numerid($pVal) && !($pVal === 0) && empty($pVal)){
			$this->errors[] = self::INVALID_ID;
			return 0;
		}else{
			$this->id = $pVal;
			return 1;
		}
	}
	
	public function setClef($pVal){
		if(empty($pVal)){
			$this->errors[] = self::INVALID_CLEF;
			return 0;
		}else{
			$this->clef = \Utils::protect($pVal);
			return 1;
		}
	}
	
	public function setValeur($pVal){
		if(empty($pVal)){
			$this->errors[] = self::INVALID_VALEUR;
			return 0;
		}else{
			$this->valeur = \Utils::protect($pVal);
			return 1;
		}
	}
	
	public function setLang($pVal){
		if(empty($pVal)){
			$this->errors[] = self::INVALID_LANG;
			return 0;
		}else{
			$this->lang = \Utils::getFormatLanguage($pVal);
			return 1;
		}
	}
	
	public function id() {
		if (isset($this->id)) {
			return $this->id;
		} else {
			return 0;
		}
	}
	
	public function clef() {
		if (isset($this->clef)) {
			return $this->clef;
		} else {
			return "";
		}
	}
	
	public function valeur() {
		if (isset($this->valeur)) {
			return $this->valeur;
		} else {
			return "";
		}
	}
	
	public function lang() {
		if (isset($this->lang)) {
			return $this->lang;
		} else {
			return \Utils::defaultLanguage();
		}
	}
}

?>