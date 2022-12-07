<?php

Class MembersVideosController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectUser"])
        {
            $template = "membersVideos";

            $this->render($template);
        }
        else
		{
			$template = "connect";

			$this->render($template);
		}
    }
}