<?php

Class HomeController extends AbstractController
{
    public function index() :void
    {
        $template = "home";

        $this->render($template);

    }
}