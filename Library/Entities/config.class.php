<?php

namespace Library\Entities;

if (!defined("EVE_APP"))
	exit();

class config extends \Library\Entity{
	protected $id;
	protected $clef;
	protected $valeur;

	CONST INVALID_ID = 1;
	CONST INVALID_KEY = 1;
	CONST INVALID_VALUE = 2;
	
	public function setId($pVal){
		if(!is_numerid($pVal) && !($pVal === 0) && empty($pVal)){
			$this->errors[] = self::INVALID_ID;
			return 0;
		}else{
			$this->id = $pVal;
			return 1;
		}
	}
	
	public function setKey($pVal){
		if(empty($pVal)){
			$this->errors[] = self::INVALID_KEY;
			return 0;
		}else{
			$this->key = \Utils::protect($pVal);
			return 1;
		}
	}
	
	public function setValue($pVal){
		if(empty($pVal)){
			$this->errors[] = self::INVALID_VALUE;
			return 0;
		}else{
			$this->value = \Utils::protect($pVal);
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
}

?>