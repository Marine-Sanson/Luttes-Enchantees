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
            //Sinon renvoie vers la connection
			$template = "connect";

			$this->render($template);
		}
    }
}