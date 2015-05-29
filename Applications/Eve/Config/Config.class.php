<?php

namespace Applications\Eve\Config;

if (!defined("EVE_APP"))
	exit();

/*
*
* Application de la Plateforme de Publication
*
* @extends Application
*
*/
class Config extends \Library\AppConfig{
	
	const LOG = false;
	
	const BDD_HOST = "localhost";
	const BDD_NAME = "eve";
	const BDD_USER = "root";
	const BDD_PASSWORD = "admin";
	
	const MAX_ADMIN_LVL = 10;
	
	const DAO = "PDO";
}

?>
