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
            //Sinon renvoie vers la connexion
			$template = "connect";

			$token = $this->generateToken(20);
			$_SESSION["tokenRequiredForMemberConnection"] = $token;
	
			$this->render($template, ["token" => $token]);		}
    }
}