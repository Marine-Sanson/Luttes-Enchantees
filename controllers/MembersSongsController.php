<?php

Class MembersSongsController extends AbstractController
{
    public function index() :void
    {
        $template = "membersSongs";

        $this->render($template);

    }

    public function songDetail() :void
    {
        
    }
}