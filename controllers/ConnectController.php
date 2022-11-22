<?php

Class ConnectController extends AbstractController
{
    public function index() :void
    {
        $template = "connect";

        $this->render($template);

    }
}