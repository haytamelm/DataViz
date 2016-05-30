<?php 
session_start(); 
 if(isset($_POST['submit']))
						{
							$num_uploads = count($_FILES['userfile']['name']);
							$total_files = count($_FILES['userfile']['name']);
                            
                            if (!file_exists('uploaded/')) {
                                mkdir('uploaded/', 0777, true);
                            }
                            
							$uploaddir = 'uploaded/';
							$uploadfiles = [];
							
							for($i = 0; $i < $total_files; $i++)
							{
								$uploadfiles[] = $uploaddir.basename($_FILES['userfile']['name'][$i]);
			
								if (!move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $uploadfiles[$i]))
								{
									$num_uploads--;
								}
							}
							if($num_uploads == $total_files){
								$_SESSION["uploadfiles"] = $uploadfiles;
								$_SESSION["upass"] = 1;
								header('Location: xmltomysql.php');
								//echo 'nice';
							}
							else{
								//header('Location: errorupload.html');
								echo 'e33oor';
							}
						}
						
						?>   