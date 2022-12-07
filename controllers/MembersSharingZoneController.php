<?php

Class MembersSharingZoneController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectUser"])
        {
            $template = "membersSharingZone";

            $this->render($template);
        }
        else
		{
			$template = "connect";

			$this->render($template);
		}
    }
}