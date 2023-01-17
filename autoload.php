<?php
/**
 * @author : Gaellan
 * @author : Marine Sanson
 */

require "./controllers/AbstractController.php";
require "./services/Router.php";

require "./models/User.php";
require "./models/Song.php";
require "./models/Voice.php";
require "./models/Text.php";
require "./models/Image.php";
require "./models/SahringItem.php";
require "./models/ChatItem.php";
require "./models/SharingCategory.php";
require "./models/Event.php";

require "./managers/UserManager.php";
require "./managers/SongsManager.php";
require "./managers/VoiceManager.php";
require "./managers/TextManager.php";
require "./managers/EventManager.php";
require "./managers/ParticipationManager.php";
require "./managers/SahringItemManager.php";
require "./managers/SahringCategoriesManager.php";
require "./managers/ShareAnswerManager.php";
require "./managers/ChatItemsManager.php";
require "./managers/ChatAnswersManager.php";

require "./controllers/FileUploader.php";

require "./controllers/HomeController.php";
require "./controllers/ContactController.php";
require "./controllers/ConnectController.php";
require "./controllers/MembersHomeController.php";
require "./controllers/MembersListController.php";
require "./controllers/MembersSongsController.php";
require "./controllers/MembersChatController.php";
require "./controllers/MembersSharingZoneController.php";
require "./controllers/MembersEventsController.php";
require "./controllers/MembersVideosController.php";
require "./controllers/MembersAccountsController.php";
require "./controllers/AdminSongsController.php";
require "./controllers/AdminEventsController.php";

$routes = [];

// Read the routes config file
$handle = fopen("config/routes.txt", "r");

if ($handle) { // if the file exists

	while (($line = fgets($handle)) !== false) { // read it line by line

		$route = []; // each route is an array

		$routeData = explode(" ", str_replace(PHP_EOL, '', $line)); // divide the line in two strings (cut at the " ")

		$route["path"] = $routeData[0]; // the path is what was before the " "

		if(substr_count($route["path"], "/") > 1) // check if the path string has more than 1 "/"
		{
			$route["parameter"] = true; // the route expects a parameter
			$pathData = explode("/", $route["path"]); // divide the path in three strings (cut at the "/")
			$route["path"] = "/".$pathData[1]; // isolate the path without the parameters
		}
		else
		{
			$route["parameter"] = false; // the route does not expect a parameter
		}

		$controllerString = $routeData[1]; // the controller string is what was after the " ";

		$controllerData = explode(":", $controllerString); // divide the controller string in two strings (cut at the ":")

		$route["controller"] = $controllerData[0]; // the controller is what was before the ":"

		$route["method"] = $controllerData[1]; // the method is what was after the ":"

		$routes[] = $route; // add the new route to the routes array
	}

	fclose($handle); // close the file
}