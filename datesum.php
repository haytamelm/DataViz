<?php session_start(); 
include 'connectdb.php';
$mindate = ($conn->query("SELECT min(DATE_TWEET) FROM TWEET;")->fetch_row()[0]);
$maxdate = ($conn->query("SELECT max(DATE_TWEET) FROM TWEET;")->fetch_row()[0]);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Date Summary - DataViz</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style>
    #dates
    {
        margin-bottom: 10px;
        text-align: center;
    }
    #update
    {
        margin-left: 8px;
    }
    </style>
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
                    <li>
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
                    <li class="active">
                        <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i>Date summary</a>
                    </li>
                     <li>
                        <a href="hashcloud.php"><i class="fa fa-fw fa-cloud"></i>Hashtag Cloud</a>
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
                            Date Summary
						</h1>
                    </div>
                </div>
                <!-- /.row -->

                
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                      <div id="dates">
                        <div class="criter">Date début</div> <input type="date" id="dateDeb" value="<?php echo $mindate; ?>">
						<div class="criter">Date fin</div>   <input type="date" id="dateFin" value="<?php echo $maxdate; ?>">
                        <input type="button" id="update" value="Update" onclick="refresh();">
                        <div id="error"></div>
                        <script src="js/datesumrefresh.js" type="text/javascript"></script>
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h3>Topics</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="bs-example" data-example-id="simple-jumbotron">
                                    <div class="jumbotron">
                                        <h4><br/></h4>
                                        <h4 id="for">For:</h4>
                                        <h4 id="aga">Against:</h4>
                                        <h4 id="none">None:</h4>
                                        <h4><br/></h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h3>Languages</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="bs-example" data-example-id="simple-jumbotron">
                                    <div class="jumbotron">
                                        <h4 id="en">English:</h4>
                                        <h4 id="fr">French:</h4>
                                        <h4 id="it">Italia:</h4>
                                        <h4 id="de">Deutche:</h4>
                                        <h4 id="sp">Spanish:</h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                    
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h3>Sentiments</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="bs-example" data-example-id="simple-jumbotron">
                                    <div class="jumbotron">
                                        <h4 id="pos">Positive:</h4>
                                        <h4 id="neg">Negative:</h4>
                                        <h4 id="neu">Neutral:</h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                    
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h3>Top Hashtags</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="bs-example" data-example-id="simple-jumbotron">
                                    <div class="jumbotron">
                                        <h4 id="tophash"></h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                    
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
    
    <script>
    document.getElementById("update").click();
    </script>

</body>

</html>
