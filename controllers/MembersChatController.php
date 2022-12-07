<?php

Class MembersChatController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectUser"])
        {
            $template = "membersChat";

            $this->render($template);
        }
    }
}