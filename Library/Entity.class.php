<?php

namespace Library;

if (!defined("EVE_APP"))
	exit();


/**
 * The parent class of the entity.
 * 
 * The entities are the representation in PHP of the data that are saved on the server and that we need to work with.
 * 
 * This method provides the most generic method used by the Entities. They could be overrided to modify their work or to protect some integrity.
 * 
 * @copyright ParaGP Swizerland
 * @author Zellweger Vincent
 * @version 1.0
 * @abstract
 */
abstract class Entity {
	
	/**
	 * An instance of {@see \DateTime} used in form to check the difference of time
	 * between that a form has be created and the data are provided to the entity.
	 * 
	 * In general it could be use to block some critical modification if the time is too long
	 * 
	 * @var \DateTime
	 */
	protected $checkTime;
	
	/**
	 * A list of error provided when we try to send data to the entity and that the data
	 * are not valid
	 * 
	 * @var string[]
	 */
	protected $errors = array();
	
	/**
	 * Constructor of the Entities
	 * When gived with an array of data, the constructor try to {@see \Library\Entitiy::hydrate()}
	 * himself with this data.
	 * 
	 * @param mixed[]
	 */
	public function __construct(array $data = array()){
		if(!empty($data)){
			$this->hydrate($data);
		}
	}
	
	/**
	 * Indicate if an {@see \Library\Entity} is new or if it has be given by
	 * a {@see \Library\Manager}
	 * 
	 * @return boolean
	 */
	public function isNew(){
		return empty($this->id);
	}
	
	//Getter de l'objet
	/**
	 * Return the list of the error in the {@see \Library\Entity}
	 * 
	 * @return astring[]
	 */
	public final function errors(){
		return $this->errors;
	}
	
	/**
	 * Return whether or not theyr are som error on the {@see \Library\Entity}
	 * @return boolean
	 */
	
	public function isError(){
		return count($this->errors) != 0;
	}
	
	/**
	 * Add an error at the end of the list of error
	 * 
	 * @param String $pVal
	 *				The error value
	 */
	public function setError($pVal) {
		if(!in_array($pVal, $this->errors)){
			$this->errors[] = $pVal;
		}
	} 
	
	/**
	 * set the error list to empty list
	 */
	public function errorsInit(){
		$this->errors = array();
	}
	
	/**
	 * Give back the last error
	 * @return String
	 */
	public function lastError(){
		return $this->errors[(count($this->errors)-1)];
	}
	
	//Setter de l'objet
	
	/**
	* Function that hydrate the {@see \Library\Entity}
	* 
	* For each data in the parameter, the function try to set the data
	* in a coresponding parameter of the {@see \Library\Entities\}
	* 
	* @params $data
	* 			An array where all the key should be a parameter name
	* 			and all the value are the value that we want for this
	* 			parameters.
	* 
	* @return boolean
	* 		Whether or not all the value have been set.
	* 		If false, then the error of insertion are in the {@see \Library\Entity::$errors}
	* 
	* @throws \RuntimeException
	* 		If we try to set a value on a parameter that don't exist or that doesn't have his own
	* 		setter.
	*/
	public function hydrate(array $data){
		$ret = 1;
		
		foreach($data AS $key=>$value){
			$method = 'set' . ucfirst($key);
			
			$ret *= $this->$method($value);
		}
		
		return $ret == 1;
	}
	
	
	/**
	 * Setter for the CheckTime
	 * Try to add a new value to the checkTime. If the value is a number or a string,
	 * we try to create a new \DateTime
	 * 
	 * @see \DateTime
	 * 
	 * @param string|numeric|\DateTime|mixed $pVal
	 * @return number
	 */
	public function setCheckTime($pVal) {
		if (is_string($pVal) || is_numeric($pVal)) {
			$this->checkTime = @new \DateTime($pVal);
		} elseif ($pVal instanceof \DateTime) {
			$this->checkTime = $pVal;
		}
		return 1;
	}
	
	/**
	 * Give the current checkTime
	 * Try to get the CheckTime. If the checktime exist but is in a bad format, try to create a
	 * new \DateTime with his parameter
	 * 
	 * @see \DateTime
	 * 
	 * @return \DateTime|NULL
	 */
	public function checkTime() {
		if (isset($this->checkTime))
			if (!($this->checkTime instanceof \DateTime))
				$this->checkTime = @new \DateTime($this->dateTime);
		return $this->checkTime;
	}
	
	/**
	 * Generic setter
	 * Used when we try to use an attribute like a public attribute and not using the
	 * setValue() provided. It will just call the setter.
	 * 
	 * @param string $name
	 * @param mixed $val
	 * 
	 * @return int
	 */
	public function __set($name, $val) {
		return $this->$name($val);
	}
	
	/**
	 * Generic Getter used when try to get the value of a protected attribute instead of using
	 * the provided get function. It will just call the getter.
	 * 
	 * @param unknown $name
	 * 			The name of the attribute
	 * 
	 * @return mixed
	 * 		The value of the data
	 */
	public function __get($name) {
		return $this->$name();
	}
	
	/**
	 * This magic method is used to avoid the creation of all the getter and all the setter of the Entities
	 * 
	 * Instead of creating all the setter and getter, each time we try to set/get aa attribute, the
	 * application will get the DataTyper of the Entity, check if the provided attribute is in the DataType
	 * and if yes if the different attribute are working.
	 * 
	 * In the case of the setter, the application will check if the attribute exist and if the different data provided in
	 * the parameter match with the type of the attribute. Then it will set the value to the attribute.
	 * 
	 * In the case of the getter, the application will check if the attribute exist and if the data already has a value. If
	 * yes, then it return the value. If the attribute exist but it has no value, then the application will return a generic
	 * value (default value of the attribute in the DataType or generic default value).
	 * 
	 * @method int set[Attribute]($value) setter for the different attribute given the {@see \DataTyper_Manager} of the model
	 * @method mixed [attribute]() getter for the different attribute given the {@see \DataTyper_Manager} of the model
	 * 
	 * @param string $name
	 * @param mixed[] $pVal
	 * 
	 * @throws \RuntimeException
	 * 				Throw an exception if the argument dosen't exist in the DataType or in the object.
	 * 				An other case of throwing such exception is when it is not a set neither a get.
	 * 
	 * @return number|mixed
	 */
	public function __call($name, $pVal) {
		
		$setter = false;
		$varName = $name;
		
		if (strtolower(substr($name, 0, 3)) == "set" && count($pVal) != 0) {
			$setter = true;
			$varName = lcfirst(substr($name, 3));
		} elseif (substr($name, 0, 3) != "set" && count($pVal) == 0) {
			$varName = $name;
		} else {
			if (\Library\Application::appConfig()->getConst("LOG")) {
				throw new \RuntimeException("Error ID: " . \Library\Application::logger()->log("Error", "Entity", "Call to undefined method " . get_class($this) . "::" . $name . "()", __FILE__, __LINE__));
			} else {
				throw new \RuntimeException("Call to undefined method " . get_class($this) . "::" . $name . "() in " . __FILE__ . " on line " . __LINE__);
			}
		}
		
		if (property_exists($this, $varName)) {
			
			$class = new \ReflectionClass($this);
			$classPart = explode("\\", $class->getName());
			
			$info = \Library\DataTyper::getDataType(strtolower($classPart[count($classPart)-3]), $classPart[count($classPart)-1]);
			
			if ($info != null && key_exists($varName, $info)) {
				$info = $info[$varName];
					
				$type = $info["type"];
				if (strpos($type, "varchar") !== FALSE) {
					$type = "str";
					$default = "";
				} elseif($type == "text") {
					$type = "str";
					$default = "";
				} elseif($type == "tinyint(1)") {
					$type = "int";
					$default = 0;
				} elseif (strpos($type, "int") !== FALSE) {
					if (strpos($varName, "_id") !== FALSE || $varName == "id") {
						$type = "id";
						$default = 0;
					} else {
						$type = "int";
						$default = -1;
					}
				} elseif ($type == "datetime" | $type = "date") {
					$type = "date";
					$default = new \DateTime();
				} elseif (strpos($type, "enum") !== FALSE) {
					$type = "enum";
					$listeData = array();
					$listeData = explode("', '", substr($type, 6, -2));
					
					if (count($listeData)) {
						$default = $listeData[0];
					} else {
						if (\Library\Application::appConfig()->getConst("LOG")) {
							throw new \RuntimeException("Error ID: " . \Library\Application::logger()->log("Error", "Entity", "No data allowed for the propreties " . $varName . " - Type " . $type, __FILE__, __LINE__));
						} else {
							throw new \RuntimeException("No data allowed for the propreties " . $varName . " - Type " . $type);
						}
					}
				
				} else {
					$type = "str";
					$default = "";
				}
				
				if ($info["default"] != null) {
					$default = $info["default"];
				}
				
				$constName = "INVALID_".strtoupper($varName);
				
				$myClass = new \ReflectionClass($this);
				
				if ($myClass->hasConstant($constName)) {
					$necessary = true;
					$error_code = $myClass->getConstant($constName);
				} else {
					$necessary = false;
				}
				
				if ($setter) {
					switch ($type) {
						case "int":
							if (count($pVal) == 1 && is_numeric($pVal[0]) && (!empty($pVal[0]) || $pVal[0] === 0)) {
								$this->$varName = $pVal[0];
								return 1;
							}
							break;
						case "id":
							if (count($pVal) == 1 && is_numeric($pVal[0]) && (!empty($pVal[0]) || $pVal[0] === 0) && $pVal[0] > -1) {
								$this->$varName = $pVal[0];
								return 1;
							}
							break;
						case "date":
							if (count($pVal) == 3 && is_numeric($pval[0]) && is_numeric($pVal[1]) && is_numeric($pVal[2]) && $pVal[0] > 0 && $pVal[0] <= 31 && $pVal[1] > 0 && $pVal[1] <= 12) {
								try {
									$this->$varName = \DateTime::createFromFormat($pVal[0]."-".$pVal[1]."-".$pVal[2], "d-m-Y");
								} catch (\Exception $e) {
								}
							} elseif (count($pVal) == 1)
								if (is_string($pVal[0])) {
									try {
										$this->$varName = new \DateTime($pVal[0]);
									} catch (\Exception $e) {
									}
								} elseif ($pVal[0] instanceof \DateTime) {
									$this->$varName = $pVal[0];
									return 1;
								}
							break;
						case "enum":
							if (count($pVal) == 1 && in_array($pVal[0], $listeData)) {
								$this->$varName = $pVal[0];
								return 1;
							}
							break;
						case "str":
						default:
							if (count($pVal) == 1 && is_string($pVal[0]) && !empty($pVal[0])) {
								$this->$varName = \Utils::protect($pVal[0]);
								return 1;
							}
					}
					
					if ($necessary) {
						$this->setError($error_code);
						return 0;
					} else {
						$this->$varName = $default;
						return 1;
					}
				} else {
					if (isset($this->$varName)) {
						if ($type == "enum" && !in_array($this->$varName, $listeData)) {
							return $listeData[0];
						} elseif ($type == "date" && !($this->$varName instanceof \DateTime)) {
							$this->$varName = new \DateTime($this->$varName);
						}
						return $this->$varName;
					} else {
						return $default;
					}
				}
			} else {
				if (\Library\Application::appConfig()->getConst("LOG")) {
					throw new \RuntimeException("Error ID: " . \Library\Application::logger()->log("Error", "Entity", "The parameters [" . $varName . "] is not in the BDD representation of the Entity", __FILE__, __LINE__));
				} else {
					throw new \RuntimeException("The parameters [" . $varName . "] is not in the BDD representation of the Entity");
				}
			}
			
		} else {
			if (\Library\Application::appConfig()->getConst("LOG")) {
				throw new \RuntimeException("Error ID: " . \Library\Application::logger()->log("Error", "Entity", "The properties " . $varName . " is not part of the Entity [" . get_class($this) . "] or the Entity is not in the BDD representation", __FILE__, __LINE__));
			} else {
				throw new \RuntimeException("The properties " . $varName . " is not part of the Entity [" . get_class($this) . "] or the Entity is not in the BDD representation");
			}
			
		}
	}
}

?>