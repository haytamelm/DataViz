<html>
<head>
    <title></title>
    <meta charset="UTF-8">
</head>
<body>
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

    <div id="demo">kal</div>

    <script>

    var upfile = "<?php echo $uploadfile; ?>";

    xmlHTTP = new XMLHttpRequest();

    try{
        xmlHTTP.open("GET", upfile, false);
        xmlHTTP.send(null);
    }
    catch (e) {
        window.alert("Unable to load the requested file.");
    }
    parser = new DOMParser();
    xmlDoc = parser.parseFromString(xmlHTTP.responseText, "text/xml");

    senseis = xmlDoc.getElementsByTagName("senseiClipping");

    var txtx = '';

    for ( var i = 0; i < senseis.length ; i++ ){
    	childSenseis = senseis[i].childNodes;
		for ( var j = 0; j < childSenseis.length ; j++ ){
			if(childSenseis[j].nodeType == 1){
				if(childSenseis[j].tagName.toLowerCase() == 'date'){
					var date = childSenseis[j].firstChild.nodeValue;
				}
				if(childSenseis[j].tagName.toLowerCase() == 'author'){
					var auteur = childSenseis[j].firstChild.nodeValue;
				}
				if(childSenseis[j].tagName.toLowerCase() == 'text'){
					var text = childSenseis[j].firstChild.nodeValue;
				}
			}
    	}
		txtx += date + ' <strong>' + auteur + '</strong>' + ' à écrit:<br/>' + text + '<br/><br/>';
    }

    document.getElementById('demo').innerHTML = txtx;
    </script>
</body>
</html>