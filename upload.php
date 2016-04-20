<?php

if(isset($_POST['submit']))
{

	$uploaddir = 'uploaded/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

	echo '<pre>';
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
	{
		echo "Le fichier a �t� t�l�charg� avec succ�s";
	} 
	else 
	{
		switch ($_FILES['userfile']['error']) 
		{ 
			case UPLOAD_ERR_INI_SIZE: 
				$message = "Le fichi� t�l�charg� d�passe la directive upload_max_filesize configur� dans php.ini"; 
				break; 
			case UPLOAD_ERR_FORM_SIZE: 
				$message = "Le fichi� t�l�charg� d�passe la directive MAX_FILE_SIZE sp�cifi� dans le formulaire HTML"; 
				break; 
			case UPLOAD_ERR_PARTIAL: 
				$message = "Le fichier n'a pas �t� totalement t�l�charg�"; 
				break; 
			case UPLOAD_ERR_NO_FILE: 
				$message = "Aucun fichier sp�cifi�"; 
				break; 
			case UPLOAD_ERR_NO_TMP_DIR: 
				$message = "Dossier temporaire introuvable"; 
				break; 
			case UPLOAD_ERR_CANT_WRITE: 
				$message = "Eched d'�criture du fichier sur le disque"; 
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