<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Acceuil - DataViz</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <script src="js/d3.js"></script>
    <script type="text/javascript" src="d3.layout.cloud.js"></script>
    <script type="text/javascript" src="medley.js"></script>

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
                        <a href="javascript:;" data-toggle="collapse" data-target="#hash"><i class="fa fa-fw fa-arrows-v"></i> Hashtag Radar: <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="hash" class="collapse">
                            <li>
                                <a href="radarChartTopic.php">Topic</a>
                            </li>
                            <li>
                                <a href="radarChartLangue.php">Langugage</a>
                            </li>
							<li>
                                <a href="RadarChartSentiment.php">Sentiment</a> 
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="datesum.php"><i class="fa fa-fw fa-bar-chart-o"></i>Date summary</a>
                    </li>
                    <li class="active">
                        <a href="#"><i class="fa fa-fw fa-cloud"></i>Hashtag Cloud</a>
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
                            Hashtag Cloud
						</h1>
                    </div>
                </div>
                <!-- /.row -->

                
                <!-- / vide row -->

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

                <!-- cloud row -->    
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                            <div id="word-cloud"></div>
                <?php

                    include 'connectdb.php';

                    $data_text ="Name\tG";

                    $top_hashtags = $conn->query("SELECT TXT_HASHTAG,COUNT(*) AS NUM
                       FROM hashtag
                       JOIN tweet ON hashtag.ID_TWEET = tweet.ID_TWEET
                       GROUP BY TXT_HASHTAG
                       ORDER BY NUM DESC
                       LIMIT 100;"
                       )->fetch_all();
                    for($i = 0; $i < 100; $i++)
                    {
                     $data_text .= "\n".$top_hashtags[$i][0]."\t".($top_hashtags[$i][1])*0.4;
                 }

                 $dfile = fopen("word-cloud.tsv", "w") or die("Unable to open file!");
                 fwrite($dfile, $data_text);
                 fclose($dfile);
                 $conn->close();

                 //echo 'ready';
                 ?>
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
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
