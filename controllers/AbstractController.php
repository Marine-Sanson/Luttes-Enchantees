<?php

abstract class AbstractController
{
	protected UserManager $um;
	protected SongsManager $sm;
	protected SongsCategoriesManager $sgcm;
	protected VoiceManager $vm;
	protected TextManager $tm;
	protected EventManager $em;
	protected ParticipationManager $pm;
	protected SahringItemManager $sim;
	protected SahringCategoriesManager $scm;
	protected ShareAnswerManager $sam;
	protected ChatItemsManager $cim;
	protected ChatAnswersManager $cam;
	protected FileUploader $fu;

	// fonction qui initialise chacun des managers de façon à les rendre accessibles ensuite
	public function init(UserManager $um, SongsManager $sm, SongsCategoriesManager $sgcm, VoiceManager $vm, TextManager $tm, EventManager $em, ParticipationManager $pm, SahringItemManager $sim, SahringCategoriesManager $scm, ShareAnswerManager $sam, ChatItemsManager $cim, ChatAnswersManager $cam, FileUploader $fu)
	{
		$this->um = $um;
		$this->sm = $sm;
		$this->sgcm = $sgcm;
		$this->vm = $vm;
		$this->tm = $tm;
		$this->em = $em;
		$this->pm = $pm;
		$this->sim = $sim;
		$this->scm = $scm;
		$this->sam = $sam;
		$this->cim = $cim;
		$this->cam = $cam;
		$this->fu = $fu;
	}

	protected function renderPartial(string $template, array $values)
	{
		$data = $values;
		
		require "templates/".$template.".phtml";
	}
	
	protected function render(string $template, array $data = null){
		
		require "templates/layout.phtml";

	}
	
	protected function clean_input($data){
		$data = trim($data); //enleve les espaces avant et après une string
		$data = stripslashes($data); // enlève les '\' d'une string
		$data = htmlspecialchars($data); //remplace certains caractères par une entité html (ex: > par &gt;)

		return $data;
	}
	
	protected function generateToken(int $size)
	{
		$random = "abcdefghijklmnopqrstuvwyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$token = '';
		for($i=0; $i<$size; $i++)
		{
		$token .= $random[rand(0, strlen($random)-1)];
		}
		return $token;
	}    
}