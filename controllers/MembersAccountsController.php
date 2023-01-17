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
            //Sinon renvoie vers la connection
			$template = "connect";

			$this->render($template);
		}
    }
}