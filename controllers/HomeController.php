<?php

Class HomeController extends AbstractController
{
    public function index() :void
    {
        $template = "membersHome";

        $this->render($template);

    }
}