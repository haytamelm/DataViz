<?php

if(isset($_POST['submit']))
{

	$uploaddir = 'uploaded/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

	echo '<pre>';
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
	{
		echo "Le fichier a été téléchargé avec succès";
	} 
	else 
	{
		switch ($_FILES['userfile']['error']) 
		{ 
			case UPLOAD_ERR_INI_SIZE: 
				$message = "Le fichié téléchargé dépasse la directive upload_max_filesize configuré dans php.ini"; 
				break; 
			case UPLOAD_ERR_FORM_SIZE: 
				$message = "Le fichié téléchargé dépasse la directive MAX_FILE_SIZE spécifié dans le formulaire HTML"; 
				break; 
			case UPLOAD_ERR_PARTIAL: 
				$message = "Le fichier n'a pas été totalement téléchargé"; 
				break; 
			case UPLOAD_ERR_NO_FILE: 
				$message = "Aucun fichier spécifié"; 
				break; 
			case UPLOAD_ERR_NO_TMP_DIR: 
				$message = "Dossier temporaire introuvable"; 
				break; 
			case UPLOAD_ERR_CANT_WRITE: 
				$message = "Eched d'écriture du fichier sur le disque"; 
				break; 

			default: 
				$message = "Erreur Inconnue"; 
				break; 
		}
		echo $message;
	}
}
else
{
	echo '<center>Error: no file specified !</center>';
}

?>