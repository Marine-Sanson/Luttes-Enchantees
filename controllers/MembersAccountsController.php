<?php

class MembersAccountsController extends AbstractController
{
	public function index(): void
	{
		if ($_SESSION["connectUser"])
		{
			//Renvoie vers "membersAccounts"
			$template = "membersAccounts";

			$this->render($template);
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