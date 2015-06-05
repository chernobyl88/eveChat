<?php

namespace Library;

if (!defined("EVE_APP"))
	exit();

/**
 * Class Manager specialized for PDO.
 * 
 * This class describes all the different classes that are needed by {@see \Library\Manager} to work. Those functions are generalized and could be overrided to change their work.
 * 
 * It avoids the user to create all the basic functions that are normaly used.
 * 
 * @see \Library\Manager
 * 
 * @copyright ParaGP Swizerland
 * @author Zellweger Vincent
 * @version 1.0
 * @abstract
 */
abstract class Manager_PDO extends \Library\Manager {
	
	/**
	 * The name of the table
	 * @var string
	 */
	protected $table_name;
	
	/**
	 * The namespace and class of the entity coresponding to the manager
	 * @var string
	 */
	protected $entity_name;
	
	/**
	 * The DataType of the table
	 * @var string[]
	 */
	protected $listeElem;

	/**
	 * Constructor of the general PDO manager
	 * 
	 * This constructor has to
	 * 
	 * - Create the table_name with the model and the module (if not null)
	 * - Create the entity_name with all his namespace
	 * - Get all the DataType for this entity given the model and the module
	 * 
	 * @param DAO $dao
	 * @param string $api
	 * @param string|null $module
	 * @param string $model
	 */
	public function __construct($dao, $api, $module, $model){
		
		parent::__construct($dao, $api, $module, $model);
		
		if ($module != null) {
			$module = strtolower($module);
			
			$this->table_name = $module . "_" . $model;
			
			$this->entity_name = "\\Modules\\" . ucfirst($module) . "\\Entities\\" . $model;
			
		} else {
			$this->table_name = $model;
			
			$this->entity_name = "\\Library\\Entities\\" . $model;
		}
		
		
		$this->listeElem = \Library\DataTyper::getDataType($module, $model);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Library\Manager::get()
	 */
	public function get($pId) {
		$sql = "SELECT `" . implode("`, `", array_keys($this->listeElem)) . "` FROM " . $this->table_name . " WHERE id = :pId;";
		
		$query = $this->dao->prepare($sql);
		
		$query->bindValue(':pId', $pId, \PDO::PARAM_INT);
		
		$query->execute();

		$query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->entity_name);
		
		return $query->fetch();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Library\Manager::getList()
	 */
	public function getList(array $conditions = array()) {
		$sql = "SELECT `" . implode("`, `", array_keys($this->listeElem)) . "` FROM `" . $this->table_name . "`";
		
		if (count($conditions))
			$sql .= " WHERE (" . implode(") AND (", $conditions) . ")";
		
		$sql .= ";";
		
		$query = $this->dao->prepare($sql);
		
		$query->execute();

		$query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->entity_name);
		
		return $query->fetchAll();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Library\Manager::update()
	 */
	public function update(\Library\Entity $pEntity) {
		$sql = "UPDATE " . $this->table_name . " SET " . implode(", ", array_map(function ($elem) { return "`" . $elem . "` = :p" . ucfirst($elem);}, array_filter(array_keys($this->listeElem), function ($elem) { return $elem != "id";}))) . " WHERE id = :pId;";
		
		$query = $this->dao->prepare($sql);
		
		foreach ($this->listeElem AS $key=>$elem) {
			$type = $elem["type"];
			if($type == "tinyint(1)" || strpos($type, "int") !== FALSE) {
				$query->bindValue(":p".ucfirst($key), $pEntity->__call($key, array()), \PDO::PARAM_INT);
			} elseif ($type == "datetime" | $type = "date") {
				$query->bindValue(":p".ucfirst($key), \Utils::dateToDb($pEntity->__call($key, array())), \PDO::PARAM_STR);
			} else {
				$query->bindValue(":p".ucfirst($key), $pEntity->__call($key, array()), \PDO::PARAM_STR);
			}
		}
		
		if ($query->execute()) {
			return 1;
		} else {
			return -2;
		}
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Library\Manager::insert()
	 */
	public function insert(\Library\Entity $pEntity) {
		
		$sql = "INSERT INTO  "
					. $this->table_name
				 	. " (`id`, `" . implode("`, `", array_filter(array_keys($this->listeElem), function ($elem) { return $elem != "id";})) . "`)"
				 . " VALUES"
				 	. " (NULL, " . implode(", ", array_map(function ($elem) { return ":p" . ucfirst($elem);}, array_filter(array_keys($this->listeElem), function ($elem) { return $elem != "id";}))) . ");";
		
		$query = $this->dao->prepare($sql);
		
		foreach ($this->listeElem AS $key=>$elem) {
			if ($key != "id") {
				$type = $elem["type"];
				if($elem == "tinyint(1)" || strpos($type, "int") !== FALSE) {
					$query->bindValue(":p".ucfirst($key), $pEntity->__call($key, array()), \PDO::PARAM_INT);
				} elseif ($type == "datetime" | $type = "date") {
					$query->bindValue(":p".ucfirst($key), \Utils::dateToDb($pEntity->__call($key, array())), \PDO::PARAM_STR);
				} else {
					$query->bindValue(":p".ucfirst($key), $pEntity->__call($key, array()), \PDO::PARAM_STR);
				}
			}
		}
		
		if ($query->execute()) {
			$pEntity->setId($this->dao->lastInsertId());
			return $pEntity;
		} else {
			return -2;
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Library\Manager::send()
	 */
	public function send(\Library\Entity $pEntity) {
		
		if (is_numeric($pEntity->id()) && $pEntity->id() > 0 && $pEntity->id() != null) {
			$this->update($pEntity);
		} else {
			$this->insert($pEntity);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Library\Manager::delete()
	 */
	public function delete($pId) {
		if (is_numeric($pId) && $pId > 0) 
			return $this->deleteList(array("id = " . $pId));
		
		if (\Library\Application::appConfig()->getConst("LOG"))
			throw new \InvalidArgumentException("Error ID: " . \Library\Application::logger()->log("Error", "Manager_PDO", "The ID has to be numeric value", __FILE__, __LINE__));
		else
			throw new \InvalidArgumentException("The ID has to be numeric value");
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Library\Manager::deleteList()
	 */
	public function deleteList(array $conditions = array()) {
		if (count($conditions) == 0)
			$conditions = array("TRUE");
		
		$sql =	  "DELETE FROM "
					. $this->table_name
				. " WHERE ("
					. implode(") AND (", $conditions)
				. ");";
		
		$query = $this->dao->prepare($sql);
		
		return $query->execute();
	}
}

?>