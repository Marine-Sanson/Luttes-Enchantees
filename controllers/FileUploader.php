<?php

/**
 * File Uploader class used for media upload
 * @author Mari Doucet
 * @author Marine Sanson
*/

class FileUploader
{
	private string $uploadDir = "/uploads/";
	private array $allowedImageTypes = ["png", "PNG", "jpg", "JPG", "jpeg", "JPEG"];
	private array $allowedVoiceTypes = ["mp3", "MP3", "mp4", "MP4", "mpeg"];
	private array $allowedTextTypes = ["jpg", "JPEG", "pdf", "doc", "docx"];
	private array $mimeImageTypes = ['png' => 'image/png', 'PNG' => 'image/PNG', 'jpeg' => 'image/jpeg',
	'JPG' => 'image/JPG', 'jpg' => 'image/jpg', 'JPEG' => 'image/JPEG'];
	private array $mimeVoiceTypes = ['mp3' => 'audio/mpeg', 'MP3' => 'audio/mpeg', 'mp4' => 'audio/mp4', 'MP4' => 'audio/mp4'];
	private array $mimeTextTypes = ['jpeg' => 'image/jpeg',
	'JPG' => 'image/JPG', 'jpg' => 'image/jpg', 'JPEG' => 'image/JPEG', 'pdf' => 'application/pdf', 'doc' => 'application/msword', 'docx' =>'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
	private int $maxVoiceSize = 4500000; // 4.5 Mo
	private int $maxTextSize = 3500000; // 3.5 Mo
	private int $maxImageSize = 2000000; // 2 Mo


	private function generateRandomNumbers() : string
	{
		$randomString = bin2hex(random_bytes(3)); // random string, 20 characters a-z 0-9
		return $randomString;
	}

	private function generateFileName(string $title, string $mediaType) : string
	{
		$randomString = $this->generateRandomNumbers();
		$fileName = $title . "_" . $mediaType . "_" . $randomString;
		return $fileName;
	}

	private function checkFileSize(int $fileSize, int $maxFileSize) :bool
	{
		$maxFileSize = $this->maxVoiceSize;
		// vérifier que le fichier n'est pas trop gros
		if($fileSize < $maxFileSize || $fileSize > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	private function checkFileType(string $fileType, array $allowedFileTypes) :bool
	{
		// vérifier que le type est bien l'un des types autorisés
		if(in_array($fileType, $allowedFileTypes))
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	
	public function uploadVoice(array $file, int $songId, string $title, string $voiceType) : array
	{
		var_dump("entre dans uploadVoice");
		$errors = [];
		$fileToUpload = $file['fileToUpload'];
		
		$fileTypeCheked = false;
		$fileSizeCheked = false;

		if($fileToUpload !== [] && $fileToUpload['type'] !== "")
		{
			$explode = explode("/", $fileToUpload['type']);
			$fileType = $explode[1];
			var_dump($fileType);
			$allowedTypes = $this->allowedVoiceTypes;
			
			// appeler $this->checkFileType(string $fileType) pour vérifier le type du fichier
			$fileTypeCheked = $this->checkFileType($fileType, $allowedTypes);
			var_dump($fileTypeCheked);

		}
		else
		{
			$errors[] = "problème de type de fichier, merci de vérifier et de recommencer";
		}
		
		if($fileToUpload !== [] && $fileToUpload['size'] !== "")
		{
			$maxFileSize = $this->maxVoiceSize;
			$fileSizeCheked = $this->checkFileSize($fileToUpload['size'], $maxFileSize);
			var_dump($fileSizeCheked);
		}
			
		if(!$fileTypeCheked)
		{
			$errors[] = "ce type de fichier n'est pas autorisé ou fichier inexistant";
			$return = $errors;
		}
		
		if(!$fileSizeCheked)
		{
			$errors[] = "fichier trop gros ou inexistant";
			$return = $errors;
		}
		
		$validation = "";
		
		if(isset($errors) && count($errors) > 0)
		{
			$validation = "";
		}
		else
		{
			var_dump("entre dans else");
			var_dump($fileToUpload);

			$originalName = $fileToUpload["name"];
			$voiceForFileName = "voix-" . $voiceType;
			$fileName = $this->generateFileName($title, $voiceForFileName);
			$fileType = pathinfo($originalName)["extension"];
			$path = getcwd() . $this->uploadDir . "voix/" . $fileName . ".". $fileType;
			$url = "http://localhost/Luttes-Enchantees/uploads/voix/" . $fileName . ".". $fileType;

			var_dump($fileType);
			var_dump($path);
			var_dump($url);
			
			move_uploaded_file($fileToUpload["tmp_name"], $path);

			$voice = new Voice(null, $songId, $voiceType, $originalName, $fileName, $fileType, $url);
			
			$fileToUpload = $voice;
		}

		$return = ["fileToUpload" => $fileToUpload, "errors" => $errors, "validation" => $validation];
		return $return; 
	}

	public function uploadText(array $file, int $songId, string $title) : array
	{
		$errors = [];
		$fileToUpload = $file['fileToUpload'];
		
		$fileTypeCheked = false;
		$fileSizeCheked = false;

		if($fileToUpload !== [] && $fileToUpload['type'] !== "")
		{
			$explode = explode(".", $fileToUpload['name']);
			$fileType = $explode[1];
			$allowedTypes = $this->allowedTextTypes;
			
			// appeler $this->checkFileType(string $fileType) pour vérifier le type du fichier
			$fileTypeCheked = $this->checkFileType($fileType, $allowedTypes);
		}
		else
		{
			$errors[] = "problème de type de fichier, merci de vérifier et de recommencer";
		}
		
		if($fileToUpload !== [] && $fileToUpload['size'] !== "")
		{
			$maxFileSize = $this->maxTextSize;
			$fileSizeCheked = $this->checkFileSize($fileToUpload['size'], $maxFileSize);
		}
			
		if(!$fileTypeCheked)
		{
			$errors[] = "ce type de fichier n'est pas autorisé ou fichier inexistant";
			$return = $errors;
		}
		
		if(!$fileSizeCheked)
		{
			$errors[] = "fichier trop gros ou inexistant";
			$return = $errors;
		}
		
		$validation = "";
		
		if(isset($errors) && count($errors) > 0)
		{
			$validation = "";
		}
		else
		{
			$originalName = $fileToUpload["name"];
			$mediaType = "paroles";
			$fileName = $this->generateFileName($title, $mediaType);
			$fileType = pathinfo($originalName)["extension"];
			$path = getcwd() . $this->uploadDir . "textes/" . $fileName . ".". $fileType;
			$url = "http://localhost/Luttes-Enchantees/uploads/textes/" . $fileName . ".". $fileType;
			$tempAlt = $mediaType . " de " . $title;
			$alt = str_replace("-", " ", $tempAlt);
			
			move_uploaded_file($fileToUpload["tmp_name"], $path);

			$text = new Text(null, $songId, $originalName, $fileName, $fileType, $url, $alt);

			$fileToUpload = $text;
		}

		$return = ["fileToUpload" => $fileToUpload, "errors" => $errors, "validation" => $validation];
		return $return; 
	}

	// public function uploadImage(Image $file) : array
	// {
	// 	$errors = [];
		
	// 	if(!isset($fileToUpload) || $fileToUpload === [])
	// 	{
	// 		$fileToUpload = [];
	// 	}

	// 	$fileTypeCheked = false;
	// 	$fileSizeCheked = false;

	// 	if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['type'] !== "")
	// 	{
	// 		$explode = explode("/", $_FILES['fileToUpload']['type']);
	// 		$fileType = $explode[1];
	// 		$mimeTypes = $this->mimeTypes;
			
	// 		// appeler $this->checkFileType(string $fileType) pour vérifier le type du fichier
	// 		$fileTypeCheked = $this->checkFileType($fileType);
			
	// 	}
	// 	else
	// 	{
	// 		$errors[] = "problème de type de fichier, merci de vérifier et de recommencer";
	// 	}
		
	// 	if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] !== "")
	// 	{
	// 		$fileSizeCheked = $this->checkFileSize($_FILES['fileToUpload']['size']);
	// 	}
			
	// 	// appeler $this->checkFileSize(int $fileSize) pour vérifier le type du fichier
	// 	if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['alt'] === "")
	// 	{
	// 		$errors[] = "veuillez remplir la description";
	// 	}
		
	// 	if(!$fileTypeCheked)
	// 	{
	// 		$errors[] = "ce type de fichier n'est pas autorisé";
	// 		$return["errors"][] = $errors;
	// 	}
		
	// 	if(!$fileSizeCheked)
	// 	{
	// 		$errors[] = "fichier trop gros";
	// 		$return["errors"][] = $errors;
	// 	}
		
	// 	$validation = "";
		
	// 	if(isset($errors) && count($errors) > 0)
	// 	{
	// 		$validation = "";
	// 	}
	// 	else
	// 	{
	// 		$originalName = $file->getOriginalName();
	// 		$fileName = $this->generateFileName();
	// 		$fileType = pathinfo($originalName)["extension"];
	// 		$path = getcwd() . $this->uploadFile . $fileName . ".". $fileType;
	// 		$url = "http://localhost/SiteLuttesEnchantees/Luttes-Enchantees/uploads/" . $fileName . ".". $fileType;
	// 		$alt = $_FILES['fileToUpload']['alt'];
			
	// 		move_uploaded_file($file->getFileName(), $path);

	// 		// vérifier le mime du fichier
	// 		if(!in_array(mime_content_type($path), $mimeTypes, true)){
	// 				$errors[] = "Le fichier n'a pas été enregistré correctement !";    
	// 		}
			
	// 		$media = new Image(null, $originalName, $fileName, $fileType, $url, $alt);
			
	// 		$fileToUpload[] = $media;
	// 		$validation = "votre image a été chargée correctement";
	// 	}
	// 	$return = ["fileToUpload" => $fileToUpload, "errors" => $errors, "validation" => $validation];
	// 	return $return; 
	// }

} 