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
		$userManager = $this->managers()->getManagersOf("user");
		
		$user = $userManager->get($this->app->user()->id());
		
		$tech = $listeTech[rand(0, (count($listeTect)-1))];
		
		
		if ($user == null) {
		
		} else {
			
		}
		$this->page() ->addVar("error");
	}
}
?>