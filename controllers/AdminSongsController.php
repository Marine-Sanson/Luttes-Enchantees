<?php

Class AdminSongsController extends AbstractController
{
    public function index() :void
    {
        $template = "AdminSongs";

        $this->render($template);

    }

}