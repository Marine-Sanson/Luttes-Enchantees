<?php

Class MembersVideosController extends AbstractController
{
    public function index() :void
    {
        $template = "membersVideos";

        $this->render($template);

    }
}