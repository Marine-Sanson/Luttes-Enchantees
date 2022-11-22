<?php

Class MembersRehearsalController extends AbstractController
{
    public function index() :void
    {
        $template = "membersRehearsal";

        $this->render($template);

    }
}