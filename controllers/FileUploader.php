<?php

/**
 * File Uploader class used for media upload
 * @author Mari Doucet
 * @author Marine Sanson
*/

class FileUploader
{

    private string $uploadFile = "/uploads/";
    private array $allowedImageTypes = ["png", "PNG", "jpg", "JPG", "jpeg", "JPEG"];
    private array $allowedVoiceTypes = ["mp3", "MP3"];
    private array $allowedTextTypes = ["jpg", "JPEG", "pdf", "doc", "docx"];
    private array $mimeImageTypes = ['png' => 'image/png', 'PNG' => 'image/PNG', 'jpeg' => 'image/jpeg',
    'JPG' => 'image/JPG', 'jpg' => 'image/jpg', 'JPEG' => 'image/JPEG'];
    private array $mimeVoiceTypes = ['mp3' => 'audio/mpeg', 'MP3' => 'audio/mpeg'];
    private array $mimeTextTypes = ['jpeg' => 'image/jpeg',
    'JPG' => 'image/JPG', 'jpg' => 'image/jpg', 'JPEG' => 'image/JPEG', 'pdf' => 'application/pdf', 'doc' => 'application/msword', 'docx' =>'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    private int $maxFileSize = 2000000; // 2 Mo

    private function generateFileName() : string
    {
        $randomString = bin2hex(random_bytes(10)); // random string, 20 characters a-z 0-9
        return $randomString;
    }
    
    private function checkFileSize(int $fileSize) :bool
    {
        $maxFileSize = $this->maxFileSize;
        // vérifier que le fichier n'est pas trop gros
        if($fileSize < $maxFileSize)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    private function checkFileType(string $fileType) :bool
    {
        // vérifier que le type est bien l'un des types autorisés
        $allowedFileTypes = $this->allowedFileTypes;
        foreach($allowedFileTypes as $key => $allowedFileType)
        {
            if($fileType === $allowedFileType)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    public function uploadVoice(Voice $file) : array
    {
        $errors = [];
        
        if(!isset($fileToUpload) || $fileToUpload === [])
        {
            $fileToUpload = [];
        }

        $fileTypeCheked = false;
        $fileSizeCheked = false;

        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['type'] !== "")
        {
            $explode = explode("/", $_FILES['fileToUpload']['type']);
            $fileType = $explode[1];
            $mimeTypes = $this->mimeTypes;
            
            // appeler $this->checkFileType(string $fileType) pour vérifier le type du fichier
            $fileTypeCheked = $this->checkFileType($fileType);
            
        }
        else
        {
            $errors[] = "problème de type de fichier, merci de vérifier et de recommencer";
        }
        
        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] !== "")
        {
            $fileSizeCheked = $this->checkFileSize($_FILES['fileToUpload']['size']);
        }
            
        // appeler $this->checkFileSize(int $fileSize) pour vérifier le type du fichier
        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['alt'] === "")
        {
            $errors[] = "veuillez remplir la description";
        }
        
        if(!$fileTypeCheked)
        {
            $errors[] = "ce type de fichier n'est pas autorisé";
            $return["errors"][] = $errors;
        }
        
        if(!$fileSizeCheked)
        {
            $errors[] = "fichier trop gros";
            $return["errors"][] = $errors;
        }
        
        $validation = "";
        
        if(isset($errors) && count($errors) > 0)
        {
            $validation = "";
        }
        else
        {
            $originalName = $file->getOriginalName();
            $fileName = $this->generateFileName();
            $fileType = pathinfo($originalName)["extension"];
            $path = getcwd() . $this->uploadFile . $fileName . ".". $fileType;
            $url = "http://localhost/SiteLuttesEnchantees/Luttes-Enchantees/uploads/voix" . $fileName . ".". $fileType;
            $alt = $_FILES['fileToUpload']['alt'];
            
            move_uploaded_file($file->getFileName(), $path);

            // vérifier le mime du fichier
            if(!in_array(mime_content_type($path), $mimeTypes, true)){
                    $errors[] = "Le fichier n'a pas été enregistré correctement !";    
            }
            
            $media = new Voice(null, $originalName, $fileName, $fileType, $url, $alt);
            
            $fileToUpload[] = $media;
            $validation = "votre image a été chargée correctement";
        }

        $return = ["fileToUpload" => $fileToUpload, "errors" => $errors, "validation" => $validation];
        return $return; 
    }

    public function uploadText(Text $file) : array
    {
        $errors = [];
        
        if(!isset($fileToUpload) || $fileToUpload === [])
        {
            $fileToUpload = [];
        }

        $fileTypeCheked = false;
        $fileSizeCheked = false;

        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['type'] !== "")
        {
            $explode = explode("/", $_FILES['fileToUpload']['type']);
            $fileType = $explode[1];
            $mimeTypes = $this->mimeTypes;
            
            // appeler $this->checkFileType(string $fileType) pour vérifier le type du fichier
            $fileTypeCheked = $this->checkFileType($fileType);
            
        }
        else
        {
            $errors[] = "problème de type de fichier, merci de vérifier et de recommencer";
        }
        
        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] !== "")
        {
            $fileSizeCheked = $this->checkFileSize($_FILES['fileToUpload']['size']);
        }
            
        // appeler $this->checkFileSize(int $fileSize) pour vérifier le type du fichier
        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['alt'] === "")
        {
            $errors[] = "veuillez remplir la description";
        }
        
        if(!$fileTypeCheked)
        {
            $errors[] = "ce type de fichier n'est pas autorisé";
            $return["errors"][] = $errors;
        }
        
        if(!$fileSizeCheked)
        {
            $errors[] = "fichier trop gros";
            $return["errors"][] = $errors;
        }
        
        $validation = "";
        
        if(isset($errors) && count($errors) > 0)
        {
            $validation = "";
        }
        else
        {
            $originalName = $file->getOriginalName();
            $fileName = $this->generateFileName();
            $fileType = pathinfo($originalName)["extension"];
            $path = getcwd() . $this->uploadFile . $fileName . ".". $fileType;
            $url = "http://localhost/SiteLuttesEnchantees/Luttes-Enchantees/uploads/" . $fileName . ".". $fileType;
            $alt = $_FILES['fileToUpload']['alt'];
            
            move_uploaded_file($file->getFileName(), $path);

            // vérifier le mime du fichier
            if(!in_array(mime_content_type($path), $mimeTypes, true)){
                    $errors[] = "Le fichier n'a pas été enregistré correctement !";    
            }
            
            $media = new Media(null, $originalName, $fileName, $fileType, $url, $alt);
            
            $fileToUpload[] = $media;
            $validation = "votre image a été chargée correctement";
        }
        $return = ["fileToUpload" => $fileToUpload, "errors" => $errors, "validation" => $validation];
        return $return; 
    }

    public function uploadImage(Image $file) : array
    {
        $errors = [];
        
        if(!isset($fileToUpload) || $fileToUpload === [])
        {
            $fileToUpload = [];
        }

        $fileTypeCheked = false;
        $fileSizeCheked = false;

        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['type'] !== "")
        {
            $explode = explode("/", $_FILES['fileToUpload']['type']);
            $fileType = $explode[1];
            $mimeTypes = $this->mimeTypes;
            
            // appeler $this->checkFileType(string $fileType) pour vérifier le type du fichier
            $fileTypeCheked = $this->checkFileType($fileType);
            
        }
        else
        {
            $errors[] = "problème de type de fichier, merci de vérifier et de recommencer";
        }
        
        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] !== "")
        {
            $fileSizeCheked = $this->checkFileSize($_FILES['fileToUpload']['size']);
        }
            
        // appeler $this->checkFileSize(int $fileSize) pour vérifier le type du fichier
        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['alt'] === "")
        {
            $errors[] = "veuillez remplir la description";
        }
        
        if(!$fileTypeCheked)
        {
            $errors[] = "ce type de fichier n'est pas autorisé";
            $return["errors"][] = $errors;
        }
        
        if(!$fileSizeCheked)
        {
            $errors[] = "fichier trop gros";
            $return["errors"][] = $errors;
        }
        
        $validation = "";
        
        if(isset($errors) && count($errors) > 0)
        {
            $validation = "";
        }
        else
        {
            $originalName = $file->getOriginalName();
            $fileName = $this->generateFileName();
            $fileType = pathinfo($originalName)["extension"];
            $path = getcwd() . $this->uploadFile . $fileName . ".". $fileType;
            $url = "http://localhost/SiteLuttesEnchantees/Luttes-Enchantees/uploads/" . $fileName . ".". $fileType;
            $alt = $_FILES['fileToUpload']['alt'];
            
            move_uploaded_file($file->getFileName(), $path);

            // vérifier le mime du fichier
            if(!in_array(mime_content_type($path), $mimeTypes, true)){
                    $errors[] = "Le fichier n'a pas été enregistré correctement !";    
            }
            
            $media = new Image(null, $originalName, $fileName, $fileType, $url, $alt);
            
            $fileToUpload[] = $media;
            $validation = "votre image a été chargée correctement";
        }
        $return = ["fileToUpload" => $fileToUpload, "errors" => $errors, "validation" => $validation];
        return $return; 
    }

} 