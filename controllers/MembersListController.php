<?php

Class MembersListController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectUser"])
        {
            $template = "membersList";

            $this->render($template);
        }
        else
		{
			$template = "connect";

			$this->render($template);
		}
    }
}