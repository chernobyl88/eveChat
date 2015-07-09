<?php

namespace Modules\Chat;

use Library\Managers;
use Library\Mailer\Mailer;
use Library\Page\Page;
if (!defined("EVE_APP"))
	exit();

class ChatController extends \Library\BackController {
	public function executeIndex(\Library\HTTPRequest $request) {
		//fonction pour lister les domaines de compétences des techniciens 
		$this->page()->addVar("listeReq", $this->managers()->getManagersOf("request")->getListUsedRequest($this->app()->user()->getLanguage()));
			
		/*$userManager = $this->managers()->getManagersOf("user");
	}
	
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
		$this->page()->addVar("nbr", $myNbr);*/
		
	}
	
	// verification des entrées de l'utlisateur sur la page d'acceuil 
	public function executeCheck(\Library\HTTPRequest $request) {
		$error = array();
		$this->app()->user()->unsetAttribute("session_id");
		
		if ($this->app->user()->isAuthenticated()  || $request->existPost("mail") || $request->existPost("request") || $problem->existPost("problem") || $agree->existPost("agree")) {
			
			if ((($this->app->user()->isAuthenticated() && !$request->existPost("mail")) || $request->existPost("mail")) && $request->existPost("request") && $agree->existPost("agree")) {
				
				if (\Utils::testEmail($request->dataPost("mail"))) {
					$this->app()->user()->setAttribute("mail", $request->dataPost("mail"));
				} else {
					$error[] = INVALID_EMAIL;
				}
				
				if (is_numeric($request->dataPost("request")))
					$this->app()->user()->setAttribute("request", $request->dataPost("request"));
				else 
					$error[] = INVALID_REQUEST;

				$this->app()->user()->setAttribute("problem", $request->dataPost("problem"));
				$this->app()->user()->setAttribute("isTech", false);
				
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
			
			
			//crée une nouvelle entrée dans la base de donnée et vérifie si l'ID et le mail son corrcet
			$userManager = $this->managers()->getManagersOf("user");
			$user = new \Modules\Chat\Entities\user(array(
				"mail" => ($this->app()->user()->isAuthenticated()) ? $this->app()->user()->id() : $this->app()->user()->getAttribute("mail"),
				"ip" => $_SERVER["REMOTE_ADDR"]
					
			));
			$userManager->send($user);
			//Génération de la session et ses vérifications
			if ($user->id() > 0) {
				 
				$sessionManager = $this->managers()->getManagersOf("session");
				
				$chatSession = new \Modules\Chat\Entities\session(array(
					"chat_request_id" =>($this->app()->session->getAttribute("request")),
					"date_deb" => new \DateTime(),
					"chat_user_id" => $user->id()
				));
				
				$sessionManager->send($chatSession);
				
				if ($chatSession->id() > 0) {
					$this->app()->user()->setAttribute("session_id", $chatSession->id());
					
					$this->page()->addVar("valid", 1);

					//Génération du chat question réponse
					$ses_ansManager = $this->managers()->getManagersOf("sesans");
						
					$chatSesAns = new \Modules\Chat\Entities\ses_ans(array(
							"date_debut" => new \DateTime(),
							"chat_answer_id" => $tech->id(),
							"chat_session_id" => $chatSession->id(),
							"date_last_check" => new \DateTime()
					));
						
					$ses_ansManager->send($chatSesAns);
					
					if ($chatSesAns->id() > 0) {
						$this->app()->user()->setAttribute("session_id", $chatSession->id());
					
						$this->page()->addVar("valid", 1);
					} else {
						$this->page()->addVar("valid", 0);
					
						$this->page()->addVar("error", array(ERROR_ON_ADDING_ON_CHAT_ANSSES));
							
					}
				} else {
					$this->page()->addVar("valid", 0);
					
					$this->page()->addVar("error", array(ERROR_ON_ADDING_ON_CHAT_SESSION));
				}
					
			} else {
				$this->page()->addVar("valid", 0);
				
				$this->page()->addVar("error", array(ERROR_ON_INSERTION_FOR_USER));
				
			}
		} else {
			$this->page()->addVar("valid", 0);
			
			$this->page()->addVar("error", $error);
		}
		$this->page()->setIsJson();
		
	}
	
	public function executeAttente(\Library\HTTPRequest $request) {
		if (!($this->app()->user()->getAttribute("mail") != null && $request->existPost("request") && $problem->existPost("problem"))) {
			$this->app()->httpResponse()->redirect($this->page()->getVar("rootLang"). "/Chat");	
			}	
	}
	
	public function executeChat(\Library\HTTPRequest $request) {
		$sessionId = $this->app()->user()->getAttribute("session_id");
		if ($sessionId != null && is_numeric($session_id)) {
			$session = $sessionManager->get($sessionId);
			if ($session != null) {
				if ($session->date_fin() == null) {
					$messageManager = $this->managers()->getManagersOf("message");
					
					$listeMessage = $messageManager->getList("chat_session_id = " . $sessionId);
					
					$this->page()->addVar("listeMessage", $listeMessage);
					
				} else {
					$this->app()->httpResponse()->redirect($this->page()->getVar("rootLang") . '/Chat/feedback.html');
					//renvois à la page de feedback car l'utilisateur à termier sa session
				}
			} else {
				//$this->app()->httpResponse()->redirect($this->page()->getVar("rootLang") . "/Chat/");
			}
		} else {
			//$this->app()->httpResponse()->redirect($this->page()->getVar("rootLang") . "/Chat/");
			//renvois à la page d'acceuil si l'utilisateur n'est pas validé par les controles ci-dessus
		}
	}
	
	public function executeLoadMessage(\Library\HTTPRequest $request) {
		$sessionId = $this->app()->user()->getAttribute("session_id");
		if ($sessionId != null && is_numeric($session_id)) {
			$session = $sessionManager->get($sessionId);
				if ($session->date_fin() == null) {
					
				} else {
					$this->app()->httpResponse()->redirect($this->page()->getVar("rootLang") . '/Chat/feedback.html');
					//renvois à la page de feedback car l'utilisateur à termier sa session
				}
			
		} else {
			$this->page()->addVar("valid", 0);
			
			$this->page()->addVar("error", array(INVALID_SESSION_ID));
			//controle pour savoir ou sera envoyé l'utilisateur
		}
		
		$this->page()->setIsJson();
	}
	
	public function executeSendMessage(\Library\HTTPRequest $request) {
		if (!($request->existPost("message")))
			$this->app()->httpResponse()->redirect404();
		
		$sessionId = $this->app()->user()->getAttribute("session_id");
		
		if (is_numeric($sessionId)) {
			
			$sessionManager = $this->managers()->getManagersOf("session");
			$session = $sessionManager->get($sessionId);
			
			if ($session != null) {
				if	($session->date_fin() != null){
				
					$message = new \Modules\Chat\Entities\message(array(
							"message" => $request->dataPost("message"),
							"chat_session" => $session->id(),
							"date_mess" => new \DateTime(),
							"chat_user" => ($this->app->user()->getAttribute("isTech")) ? null : $this->app()->user()->id(),
							"user_id" => ($this->app->user()->getAttribute("isTech")) ? $this->app()->user()->id() : null
					));
					
					if (!$message->isError()) {
						
						$messageManager = $this->managers()->getManagersOf("message");
						$messageManager->send($message);
						
						$this->page()->addVar("valid", 1);
					} else {
						$this->page()->addVar("valid", 0);
						$this->page()->addVar("error", array(ERROR_ON_INSERTION_FOR_USER));
					}				
				}else{
					$this->app()->httpResponse()->redirect($this->page()->getVar("rootLang") . '/Chat/feedback.html');
				}
			}else{
				$this->page()->addVar("valid", 0);
				$this->page()->addVar("error", array(ERROR_ON_INSERTION_FOR_USER));
				}
		} else {
			$error[]=MISS_IDENTIFICATION;
		}
	}
	//fonction pour vérifie si l'utilisateur peut accéder à la page Pleinte
	public function executePleinte(\Library\HTTPRequest $request)	{
		$sessionId = $this->app()->user()->getAttribute("session_id");
		if ($sessionId != null && is_numeric($sessionId)){
			if($session = $sessionManager->get("$session_id")){
			}else {
				//$this->app()->httpResponse()->redirect($this->page()->getVar("rootLang") . "/Chat/");
			}
		}else {
			//$this->app()->httpResponse()->redirect($this->page()->getVar("rootLang") . "/Chat/");
		}
	
	}
	
	//fonction pour vérifie si l'utilisateur peut accéder à la page Feedback
	public function executeFeedback(\Library\HTTPRequest $request) {
		$sessionId = $this->app()->user()->getAttribute("session_id");
		$error = array();
		//commentaire à désactiver
		if($sessionId /*!*/==null /*&& $sessionId = is_numeric($sessionId)*/){
			//permet de quatifier et nomminer le feedback selon les besoin
			$this->page()->addVar("typeQuestion", array("quality", "politess", "reply"));
			$this->page()->addVar("maxFeedback", (is_numeric($this->app()->config()->get("MAX_FEEDBACK"))) ? $this->app()->config()->get("MAX_FEEDBACK") : 10);
			//vérifie si la valeur existe
			if($request->existPost("quality") &&  $request->existPost("politess") && $request->existPost("reply")){
				//enregistire la valeur dans la base de données
				$this->app()->httpRequest()->dataPost("quality");
				$this->app()->httpRequest()->dataPost("politess");
				$this->app()->httpRequest()->dataPost("reply");	
				
				$date_fin = new \DateTime();
			}
		}else {
			$error[]= MISS_IDENTIFICATION;
		}
		
		$this->page()->addVar("listeError", $error);
	}
	public function executeSendFeedback(\Library\HTTPRequest $request){
		//vérifie que le feedback existe et a bien transmit
		if (!($request->existPost("feedback")))
			$this->app()->httpResponse()->redirect404();
		
			$sessionId = $this->app()->user()->getAttribute("session_id");
		
			if (is_numeric($sessionId)) {
				
			$sessionManager = $this->managers()->getManagersOf("session");
			$session = $sessionManager->get($sessionId);
			
				$feedback = ("feedback");
				if (!$feedback->isError()){

				$this->app()->httpRequest()->dataPost("feedback");
				$this->page()->addVar("valid", 1);
				
			}else{
				$this->page()->addVar("valid", 0);
				$this->page()->addVar("error", array(ERROR_ON_INSERTION_FOR_USER));
				}
		}else{
			$this->page()->addVar("valid", 0);
			$this->page()->addVar("error", array(ERROR_ON_INSERTION_FOR_USER));
		}
	}
	
	
	public function executeThanks(\Library\HTTPRequest $request){
		$this->app()->user()->unsetAttribute("session_id");
		
	}
	public function executeSendPleinte(\Library\HTTPRequest $request){
		$sessionId =$this->app()->user()->getAttribute("session_id");
		if($sessionId !=null && $sessionId = is_numeric ($sessionId)){
			if($session = $sessionManager->get("$session_id")){
				if($request->existPost("pleinte")){
					
					$this->app()->httpRequest()->dataPost("pleinte");
					
					//envois le mail de plainte de l'utilisateur à l'administrateur
					$this->app()->mailer()->setSubject("PLAINTEUSER");
					$mail = $this->app()->config()->get("ADMIN_EMAIL");
					$this->app()->mailer()->addReciever($mail);
					$this->app()->mailer()->setFile("pleinte");
					
					$this->app()->mailer()->isValid();
					$this->app()->mailer()->sendMail();
					
					$this->page()->addVar("valid", 1);
				}else{
					$this->page()->addVar("valid", 0);
					$this->page()->addVar("error", array(ERROR_ON_INSERTION_FOR_USER));
					}

			}else {
				$this->page()->addVar("valid", 0);
				$this->page()->addVar("error", array(ERROR_ON_INSERTION_FOR_USER)); 
				}
		}else {
			$this->page()->addVar("valid", 0);
			$this->page()->addVar("error", array(ERROR_ON_INSERTION_FOR_USER));
		}
		
	}
	public function executeBan(\Library\HTTPRequest $request){
		/*$this->app()->user()->unsetAttribute("session_id");*/
		
		$userManager = $this->managers()->getManagersOf("user");
		
		$userblocban = new \Modules\Chat\Entities\user(array(
				"ip" => $_SERVER["REMOTE_ADDR"],
				"date_ban" => new \ dateTime()
		) );
		
		
	}
	
	//user doit etre redéfini pour correspondre au technicien
	public function executeindexTech(\Library\HTTPRequest $request){
		if ($this->app->user()->isAuthenticated()){
			
		}else {
			//route à redéfinir pour aller sur la page connexion du technicien
			$this->app()->httpResponse()->redirect($this->page()->getVar("rootLang") . "/Chat/");
		}	
	}
	public function executePreference(\Library\HTTPRequest $request){
		if($request->existGet("request") && $request->existPost("nbrUser") && $request->existPost("acceuilMsg")){
			$this->page()->addVar("valid", 1);
		}else{
			$this->page()->addVar("valid", 0);
		}
		
	}
	
	public function executeChatTech(\Library\HTTPRequest $request){
		$sessionId = $this->app()->user()->getAttribute("session_id");
		if ($essionId = is_numeric ($sessionId)){
			if ($session = $sessionManager->get ("session_id")){
				
			}else{
				$this->app()->httpResponse()->redirect404();

			}
		}else{
			$this->app()->httpResponse()->redirect404();
		}
	}
	public function executeListUser(\Library\HTTPRequest $request){
		$sessionId = $this->app()->user()->getAttribute("session_id");
		if($sessionId = is_numeric ($sessionId)){
			if ($session = $sessionManager->get ("session_id")){
			
				$userManager = $this->managers()->getManagersOf("user");
				
				$listUser = $userManager->getList("chat_user_mail =" . sessionId);
				
				$this->page()->addVar("listUser", array($listUser));
				
			}else{
				$this->app()->httpResponse()->redirect404();
			}
		}else {
			$this->app()->httpResponse()->redirect404();
		}
	}
	public function executeInfoUser(\Library\HTTPRequest $request){
		$sessionId = $this->app()->user()->getAttribute("session_id");
		if ($sessionId = is_numeric ($sessionId)){
			if ($session = $sessionManager->get ("session_id")){
			
			}else {
				$this->app()->httpResponse()->redirect404();		
			}
		}else{
			$this->app()->httpResponse()->redirect404();
			 
		}
	}
	public function executeblocBan(\Library\HTTPRequest $request){
		//premet au technicien d'envoyer sa plainte
		if (!($request->existPost("plainteTech")))
			$this->app()->httpResponse()->redirect404();{
			
			$this->app()->httpRequest()->dataPost("plainteTech");
			
			$this->app()->mailer()->setSubject("PLAINTETECH");
			$mail = $this->app()->config()->get("ADMIN_EMAIL");
			$this->app()->mailer()->addReciever($mail);
			$this->app()->mailer()->setFile("plainteTech");
			
			$this->app()->mailer()->isValid();
			$this->app()->mailer()->sendMail();
		} 
		
		
	}

}
?>