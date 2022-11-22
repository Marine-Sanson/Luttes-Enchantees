<?php

Class MembersSharingZoneController extends AbstractController
{
    public function index() :void
    {
        $template = "membersSharingZone";

        $this->render($template);

    }
}