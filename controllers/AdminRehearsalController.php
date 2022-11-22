<?php

Class AdminRehearsalController extends AbstractController
{
    public function index() :void
    {
        $template = "AdminRehearsal";

        $this->render($template);

    }

}