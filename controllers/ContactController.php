<?php

Class ContactController extends AbstractController
{
    public function index() :void
    {
        $template = "contact";

        $this->render($template);

    }
}