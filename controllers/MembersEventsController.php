<?php

Class MembersEventsController extends AbstractController
{
	public function index() :void
	{
		$template = "membersEvents";

		$this->render($template);

	}
}