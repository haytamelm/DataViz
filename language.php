<?php 
session_start(); 
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

    <title>Language - DataViz</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style>
.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.x.axis path {
  display: none;
}

.line {
  fill: none;
  stroke: steelblue;
  stroke-width: 1.5px;
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
                    <li >
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Acceuil</a>
                    </li>
					<li class="active">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Visualisations par: <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse in">
                            <li >
                                <a href="topic.php">Topic</a>
                            </li>
                            <li class="active">
                                <a href="#">Langugage</a>
                            </li>
							<li>
                                <a href="sentiment.php">Sentiment</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="datesum.php"><i class="fa fa-fw fa-bar-chart-o"></i>Date summary</a>
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
						<h2 class="page-header">
                            Language visualisation
						</h2>						
                       
                    </div>
                </div>
                <!-- /.row -->

                <!-- visualisation section -->
                <div class="row">
					
					 <!-- tabs -->
					<div class="tab-content">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#home">Pie Chart</a></li>
							<li><a data-toggle="tab" href="#menu1">Lines Chart</a></li>
							<li><a data-toggle="tab" href="#menu2">Stacked Chart</a></li>
						</ul>
						<!-- tab pie -->
						<div id="home" class="tab-pane fade in active">
							<!-- pie section -->
							<div class="col-lg-6 col-md-12">
								<script src="d3pie/d3pie.min.js"></script>
                                <script src="js/languagerefreshpie.js" type="text/javascript"></script>
                                <script src="js/languagepiechart.js" type="text/javascript"></script>
								<div id="pieChart"></div>
							</div>
							<!-- form section -->
							<div class="col-lg-6 col-md-12">
                                <br/>
								<p><div class="criter">Language:</div></p>
								<form role="form">
									<label class="checkbox-inline"><input type="checkbox" id="pieenglish" checked>English</label>
									<label class="checkbox-inline"><input type="checkbox" id="piefrench" checked>French</label>
									<label class="checkbox-inline"><input type="checkbox" id="pieitalia" checked>Italia</label>
									<label class="checkbox-inline"><input type="checkbox" id="piedeutche" checked>Deutche</label>
									<label class="checkbox-inline"><input type="checkbox" id="piespanish" checked>Spanish</label>
								</form>
								<br/>
								<p><div class="criter">Topic:</div></p>
								<form role="form">
									<label class="checkbox-inline"><input type="checkbox" id="pieagainst" checked>Against</label>
									<label class="checkbox-inline"><input type="checkbox" id="piefor" checked>For</label>
									<label class="checkbox-inline"><input type="checkbox" id="pienone" checked>None</label>
								</form>
								<br/>
								<p><div class="criter">Sentiment:</div></p>
								<form role="form">
									<label class="checkbox-inline"><input type="checkbox" id="piepositive" checked>Positive</label>
									<label class="checkbox-inline"><input type="checkbox" id="pienegative" checked>Negative</label>
									<label class="checkbox-inline"><input type="checkbox" id="pieneutral" checked>Neutral</label>
								</form>
								<br/>
								<div class="criter">Date début </div><input type="date" id="piedateDeb" value="<?php echo $mindate; ?>">
								<div class="criter">Date fin   </div><input type="date" id="piedateFin" value="<?php echo $maxdate; ?>">
								<br/><br/>
								<input type="button" id="pieupdate" value="Update" onclick="refreshPie();">
								<div id="pieerrors"></div>
							</div>	
						</div>
						<!-- multi lines tab -->
						<div id="menu1" class="tab-pane fade">
                            <script src="js/d3.v3.min.js"></script>
                            <script src="js/languagemslinechart.js" type="text/javascript"></script>
                            <!-- multi lines section -->
							<div class="col-lg-12 col-md-12">

                                <script src="js/languagemslinerefresh.js" type="text/javascript"></script>
								<div id="mslchart"></div>
							</div>
                            <!-- multi lines form -->
							<div class="col-lg-12 col-md-12">
                            <br/>
                                <form role="form">
								<div class="criter">Topic:</div>
									<label class="checkbox-inline"><input type="checkbox" id="mslinefor" checked>For</label>
									<label class="checkbox-inline"><input type="checkbox" id="mslineagainst" checked>Against</label>
									<label class="checkbox-inline"><input type="checkbox" id="mslinenone" checked>None</label>
								<div class="criter">Sentiment:</div>
									<label class="checkbox-inline"><input type="checkbox" id="mslinepositive" checked>Positive</label>
									<label class="checkbox-inline"><input type="checkbox" id="mslinenegative" checked>Negative</label>
									<label class="checkbox-inline"><input type="checkbox" id="mslineneutral" checked>Neutral</label>
                                <br/><br/>
                                <div class="criter">Date début </div><input type="date" id="mslinedateDeb" value="<?php echo $mindate; ?>">
								<div class="criter">Date fin </div>  <input type="date" id="mslinedateFin" value="<?php echo $maxdate; ?>">
								<input type="button" id="mslineupdate" value="Update" onclick="refreshMsline();">
								<div id="mslineerrors"></div>
                              </form>
							</div>	
						</div>
						<!-- another tab -->
						<div id="menu2" class="tab-pane fade">
							<script src="js/d3.v3.min.js"></script>
                            <script src="js/topicstackedchart.js" type="text/javascript"></script>
                            <!-- multi lines section -->
							<div class="col-lg-12 col-md-12">

                                <script src="js/languagestackedrefresh.js" type="text/javascript"></script>
								<div id="stackedchart"></div>
							</div>
                            <!-- multi lines form -->
							<div class="col-lg-12 col-md-12">
                            <br/>
                                <form role="form">
								<div class="criter">Topic:</div>
									<label class="checkbox-inline"><input type="checkbox" id="stackedfor" checked>For</label>
									<label class="checkbox-inline"><input type="checkbox" id="stackedagainst" checked>Against</label>
									<label class="checkbox-inline"><input type="checkbox" id="stackednone" checked>None</label>
								<div class="criter">Sentiment:</div>
									<label class="checkbox-inline"><input type="checkbox" id="stackedpositive" checked>Positive</label>
									<label class="checkbox-inline"><input type="checkbox" id="stackednegative" checked>Negative</label>
									<label class="checkbox-inline"><input type="checkbox" id="stackedneutral" checked>Neutral</label>
                                <br/><br/>
                                <div class="criter">Date début</div> <input type="date" id="stackeddateDeb" value="<?php echo $mindate; ?>">
								<div class="criter">Date fin </div>  <input type="date" id="stackeddateFin" value="<?php echo $maxdate; ?>">
								<input type="button" id="stackedupdate" value="Update" onclick="refreshStacked();">
								<div id="stackederrors"></div>
                              </form>
							</div>	
						</div>
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
	
	<script>
	document.getElementById("pieupdate").click();
    document.getElementById("mslineupdate").click();
    document.getElementById("stackedupdate").click();
	</script>

</body>

</html>
