<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">DataViz</a>
            </div>
            <!-- Top Menu Items -->
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Acceuil</a>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Visualisations par: <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="topic.php">Topic</a>
                            </li>
                            <li>
                                <a href="language.php">Langugage</a>
                            </li>
							<li>
                                <a href="sentiment.php">Sentiment</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="charts.html"><i class="fa fa-fw fa-bar-chart-o"></i>Date summary</a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
						<h1 class="page-header">
                            Uploading Form
						</h1>
						<div style="text-align: center;margin-top: 180px;">
							<h4>Upload your XML Files Here:</h4>
							<form enctype="multipart/form-data" action="index.php" method="post">
								<span class="btn btn-default btn-file"> 
								<input name="userfile[]" type="file" multiple="multiple"> </span>
								<br/><br/>
								<input class="btn btn-primary" type="submit" name="submit" value="Envoyers les fichiers" />
							</form>
						</div>
						<?php
						
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
                    </div>
                </div>
                <!-- /.row -->

                
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        
                    </div>
                    <div class="col-lg-3 col-md-6">
                        
                    </div>
                    <div class="col-lg-3 col-md-6">
                        
                    </div>
                    <div class="col-lg-3 col-md-6">
                       
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-4">
                        
                    </div>
                    <div class="col-lg-4">
                        
                    </div>
                    <div class="col-lg-4">
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
