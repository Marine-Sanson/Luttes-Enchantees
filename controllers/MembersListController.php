<?php

Class MembersListController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectUser"])
        {
            $users = $this->um->getAllUsers();
            $template = "membersList";

            $this->render($template, ["users" => $users]);
        }
        else
		{
			$template = "connect";

			$this->render($template);
		}
    }
}