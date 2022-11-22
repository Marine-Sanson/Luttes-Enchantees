<?php

Class MembersListController extends AbstractController
{
    public function index() :void
    {
        $template = "membersList";

        $this->render($template);

    }
}