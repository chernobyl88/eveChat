<?php

namespace Modules\Chat;

if (!defined("EVE_APP"))
	exit();

class ChatController extends \Library\BackController {
	public function executeIndex(\Library\HTTPRequest $request) {
		$userManager = $this->managers()->getManagersOf("user");
		
		$requestManager = $this->managers()->getManagersOf("request");
		
		$this->page()->addVar("listeReq", $requestManager->getListUsedRequest($this->app()->user()->getLanguage()));
		
		
		
		$user = new \Modules\Chat\Entities\user(array(
			"mail" => "vz@paragp.ch",
			"ip" => $_SERVER["REMOTE_ADDR"]
		));
		
		$userManager->send($user);
		
		if ($request->existGet("value_from_get"))
			$this->page()->addVar("fromGet", "oui");
		else
			$this->page()->addVar("fromGet", "non");
			
		
		$myNbr = $this->app()->user()->getAttribute("nbr");
		
		if ($myNbr == null)
			$myNbr = 0;
		
		$this->app()->user()->setAttribute("nbr", $myNbr + 1);
		
		$users = $userManager->getList(array("mail = 'vz@paragp.ch'"));

		$this->page()->addVar("myUser", $users);
		$this->page()->addVar("nbr", $myNbr);
		
		
		
	}
	
	public function executeCheck(\Library\HTTPRequest $request) {
		$this->page()->addVar("isValid", 1);
		
		$this->page()->setIsJson();
	}
	public function executeTech (\Library\HTTPRequest $request) {
		$error = array();
		
		if ($this->app->user()->isAuthenticated()  || $request->existPost("mail") || $request->existPost("request") || $problem->existPost("problem") || $agree->existPost("agree")) {
			
			if ((($this->app->user()->isAuthenticated() && !$request->existPost("mail")) || $request->existPost("mail")) && $request->existPost("request") && $agree->existPost("agree")) {
				
				if (\Utils::testEmail($request->dataPost("mail"))) {
					$this->app()->user()->setAttribute("mail", $request->dataPost("mail"));
				} else {
					$error[] = INVALID_EMAIL;
				}
				
			} else {
				$error[] = MISS_DATA;
			}
				
		} else {
			if (!($this->app()->user()->getAttribute("mail") != null && $request->existPost("request") && $problem->existPost("problem"))) {
				$error[] = MISTAKE;
			}
				
		}
		
		if (count($error) == 0) {
			$answerManager = $this->managers()->getManagersOf("answer");
			
			$listeTech = $answerManager->getListTechDispoId();
		}
		
		if (!(count($error) == 0) && count($listeTech)) {
			$tech = $listeTech[rand(0, (count($listeTect)-1))];
			
			$this->page()->addVar("valid", 1);
			
		} else {
			$this->page()->addVar("valid", 0);
			
			$this->page()->addVar("error", $error);
		}
		$this->page()->setIsJson();
		
	}
}
?>