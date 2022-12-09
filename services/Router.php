<?php
/**
 * @author : Gaellan
 * @author : Marine Sanson
 */

class Router {

	//analyse le chemin dans routes.txt
	private function parseRequest(string $request)
	{
		$route = [];

		$routeData = explode("/", $request);

		$route["path"] = "/".$routeData[1];

		if(count($routeData) > 2)
		{
			$route["parameter"] = $routeData[2];
		}
		else
		{
			$route["parameter"] = null;
		}

		return $route;
	}

// renvoie un tableau avec les différentes routes et enventuellement les parametres
	public function route(array $routes, string $request)
	{
		$requestData = $this->parseRequest($request);

		$routeFound = false;

		foreach($routes as $route)
		{
			$controller = $route["controller"];
			$method =  trim($route["method"]);
			$parameter = $route["parameter"];

			if($route["path"] === $requestData["path"])
			{
				if($route["parameter"] && $requestData["parameter"] !== null)
				{
					$routeFound = true;

					$um = new UserManager();
					$sm = new SongsManager();
					$vm = new VoiceManager();
					$tm = new TextManager();
					$em = new EventManager();
					$pm = new ParticipationManager();
					$sim = new SahringItemManager();
					$scm = new SahringCategoriesManager();
					$fu = new FileUploader();

					$ctrl = new $controller();
					$ctrl->init($um, $sm, $vm, $tm, $em, $pm, $sim, $scm, $fu);
					$ctrl->$method($_POST, $requestData["parameter"]);
				}
				else if(!$route["parameter"] && $requestData["parameter"] === null)
				{
					$routeFound = true;
					
					$um = new UserManager();
					$sm = new SongsManager();
					$vm = new VoiceManager();
					$tm = new TextManager();
					$em = new EventManager();
					$pm = new ParticipationManager();
					$sim = new SahringItemManager();
					$scm = new SahringCategoriesManager();
					$fu = new FileUploader();

					$ctrl = new $controller();
					$ctrl->init($um, $sm, $vm, $tm, $em, $pm, $sim, $scm, $fu);
					$ctrl-> $method($_POST);
				}
			}
		}
		// exception au cas où il n'ai pas trouvé de route
		if(!$routeFound)
		{
			throw new Exception("Route not found", 404);
		}
	}
}
