<?php

Class MembersVideosController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectUser"])
        {
            //Renvoie vers "membersVideos"
            $template = "membersVideos";

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