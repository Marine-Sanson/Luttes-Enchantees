<?php

/**
 * File Uploader class used for media upload
 * @author Mari Doucet
 * @author Marine Sanson
*/

class FileUploader
{

//     private string $uploadFile = "/uploads/";
//     private array $allowedFileTypes = ["png", "PNG", "jpg", "JPG", "jpeg", "JPEG"];
//     private array $mimeTypes = ['png' => 'image/png', 'PNG' => 'image/PNG', 'jpeg' => 'image/jpeg',
//     'JPG' => 'image/JPG', 'jpg' => 'image/jpg', 'JPEG' => 'image/JPEG'];
//     private int $maxFileSize = 2000000; // 2 Mo

//     private function generateFileName() : string
//     {
//         $randomString = bin2hex(random_bytes(10)); // random string, 20 characters a-z 0-9
//         return $randomString;
//     }
    
//     private function checkFileSize(int $fileSize) :bool
//     {
//         $maxFileSize = $this->maxFileSize;
//         // vérifier que le fichier n'est pas trop gros
//         if($fileSize < $maxFileSize)
//         {
//             return true;
//         }
//     }
    
//     private function checkFileType(string $fileType) :bool
//     {
//         // vérifier que le type est bien l'un des types autorisés
//         $allowedFileTypes = $this->allowedFileTypes;
//         foreach($allowedFileTypes as $key => $allowedFileType)
//         {
//             if($fileType === $allowedFileType)
//             {
//                 return true;
//                 break;
//             }
//         }
//     }
    
//     public function upload(Media $file) : array
//     {
//         $errors = [];
        
//         if(!isset($fileToUpload) || $fileToUpload === [])
//         {
//             $fileToUpload = [];
//         }

//         $fileTypeCheked = false;
//         $fileSizeCheked = false;

//         if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['type'] !== "")
//         {
//             $explode = explode("/", $_FILES['fileToUpload']['type']);
//             $fileType = $explode[1];
//             $mimeTypes = $this->mimeTypes;
            
//             // appeler $this->checkFileType(string $fileType) pour vérifier le type du fichier
//             $fileTypeCheked = $this->checkFileType($fileType);
            
//         }
//         else
//         {
//             $errors[] = "problème de type de fichier, merci de vérifier et de recommencer";
//         }
        
//         if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] !== "")
//         {
//             $fileSizeCheked = $this->checkFileSize($_FILES['fileToUpload']['size']);
//         }
            
//         // appeler $this->checkFileSize(int $fileSize) pour vérifier le type du fichier
//         if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['alt'] === "")
//         {
//             $errors[] = "veuillez remplir la description";
//         }
        
//         if(!$fileTypeCheked)
//         {
//             $errors[] = "ce type de fichier n'est pas autorisé";
//             $return["errors"][] = $errors;
//         }
        
//         if(!$fileSizeCheked)
//         {
//             $errors[] = "fichier trop gros";
//             $return["errors"][] = $errors;
//         }
        
//         $validation = "";
        
//         if(isset($errors) && count($errors) > 0)
//         {
//             $validation = "";
//         }
//         else
//         {
//             $originalName = $file->getOriginalName();
//             $fileName = $this->generateFileName();
//             $fileType = pathinfo($originalName)["extension"];
//             $path = getcwd() . $this->uploadFile . $fileName . ".". $fileType;
//             $url = "https://marinesanson.sites.3wa.io/Projet_Accou-ferme/uploads/" . $fileName . ".". $fileType;
//             $alt = $_FILES['fileToUpload']['alt'];
            
//             move_uploaded_file($file->getFileName(), $path);

//             // vérifier le mime du fichier
//             if(!in_array(mime_content_type($path), $mimeTypes, true)){
//                     $errors[] = "Le fichier n'a pas été enregistré correctement !";    
//             }
            
//             $media = new Media(null, $originalName, $fileName, $fileType, $url, $alt);
            
//             $fileToUpload[] = $media;
//             $validation = "votre image a été chargée correctement";
//         }

//         $return = ["fileToUpload" => $fileToUpload, "errors" => $errors, "validation" => $validation];
//         return $return; 
//     }
} 