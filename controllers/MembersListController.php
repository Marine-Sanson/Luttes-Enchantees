<?php

Class MembersListController extends AbstractController
{
	public function index() :void
	{
		if($_SESSION["connectUser"])
		{
			//Va chercher tous les users
			$users = $this->um->getAllUsers();
			$template = "membersList";

			$this->render($template, ["users" => $users]);
		}
		else
		{
			//Sinon renvoie vers la connexion
			$template = "connect";

			$token = $this->generateToken(20);
			$_SESSION["tokenRequiredForMemberConnection"] = $token;
	
			$this->render($template, ["token" => $token]);
		}
	}
}