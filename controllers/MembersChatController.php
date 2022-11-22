<?php

Class MembersChatController extends AbstractController
{
    public function index() :void
    {
        $template = "membersChat";

        $this->render($template);

    }
}