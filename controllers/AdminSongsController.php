<?php

Class AdminSongsController extends AbstractController
{
    public function index() :void
    {
        $template = "adminSongs";

        if(isset($_POST) && $_POST !== [])
        {
            
        var_dump($_POST);
        var_dump($_FILES);

        }

        $allSongs = $this->sm->getAllSongsTitles();

        $this->render($template, ["allSongs" => $allSongs]);

    }

    // public function adminVoice() : void
    // {
    //     $template = "adminSongs";

    //     var_dump($_POST);
    //     var_dump($_FILES);

    //     $allSongs = $this->sm->getAllSongsTitles();

    //     $this->render($template, ["allSongs" => $allSongs]);

    // }

}