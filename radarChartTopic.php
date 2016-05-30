<?php 
include 'connectdb.php';
$mindate = $conn->query("SELECT min(DATE_TWEET) FROM TWEET;")->fetch_row()[0];
$maxdate = ($conn->query("SELECT max(DATE_TWEET) FROM TWEET;")->fetch_row()[0]);
$data_text = "date\tnone\tfor\tagainst";
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <script type="text/javascript" src="js/oXHR.js"></script>
  <script type="text/javascript" src="js/moment.min.js"></script>
  <script type="text/javascript" src="js/twix.min.js"></script>

  <script src="js/jquery.min.js"></script>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js" charset="utf-8"></script>
  <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js'></script>
  <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
  <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/ >

  <link href="css/animate.min.css" rel="stylesheet">
  <title>Topic Radar Chart - DataViz</title>

  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/sb-admin.css" rel="stylesheet">
  
  <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


  <!-- tag -->
  <link rel="stylesheet" type="text/css" href="css/jquery.tagsinput.css" />
  <script type="text/javascript" src="js/jquery.tagsinput.js"></script>
      </head>

      <body>
        <script src="js/radarChart.js"></script>
        <script type="text/javascript">
      function onAddTag(tag) {
        alert("Added a tag: " + tag);
      }
      function onRemoveTag(tag) {
        alert("Removed a tag: " + tag);
      }
      function onChangeTag(input,tag) {
        alert("Changed a tag: " + tag);
      }
      $(function() {
        $('#tags_1').tagsInput({width:'auto',placeholderColor:'#c000'});
      });
      </script>
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
                        <ul id="hash" class="collapse in">
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
                    Radar par topic
                  </h1>



                </div>
              </div>
              <!-- /.row -->


              <!-- /.row -->

              <div class="row">
                <div id="chart" class="col-lg-7 col-md-12">

                </div>
                <div class="col-lg-5 col-md-12">
                  <br/>
                  <br/>
                  <br/>
                  <br/>
                  Date début <input type="date" id="piedateDeb" value="<?php echo $mindate; ?>">
                  <br/><br/>
                  Date fin   <input type="date" id="piedateFin" value="<?php echo $maxdate; ?>">
                  <br/><br/>
                  <p><label>Defaults:</label>
                    <input id="tags_1" type="text" class="tags" value="#eu,#uk,#euref" />
                  </p>
                  <br/>
                  <button id="b1" type="button" class="btn btn-primary" onclick="request(this)">recherche</button>
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

        <script>
        var data,LegendOptions;
        var maxval=0;
        function getDates(startDate, stopDate) {
          var dateArray = [];
          var currentDate = moment(startDate);
          while (currentDate <= stopDate) {
            dateArray.push( moment(currentDate).format('YYYY-MM-DD') )
            currentDate = moment(currentDate).add(1, 'days');
          }
          return dateArray;
        }

        function request(oSelect) {

          var value1 = document.getElementById("piedateDeb").value;
          var value2 = document.getElementById("piedateFin").value;
          var value3 = document.getElementById("tags_1").value;

          var range= getDates(new Date(value1), new Date(value2));

          var xhr   = getXMLHttpRequest();

          xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
              readData(xhr.responseText);
              radarChart();
            } else if (xhr.readyState < 4) {
            }
          };

          xhr.open("POST", "getData/radarChartTopicSQL.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.send("tags=" + value3 + "&dd=" + value1 + "&df=" + value2);
        }

        function readData(oData) {  
          console.log(oData)
          oData = oData.split("aaaa");
          data = oData[0];
          LegendOptions = oData[1];
          var maxval = parseInt(oData[2]);
          maxval = maxval + 0.1;
          data = eval(data);
        }

        function radarChart(){

          var w = 500,
          h = 500;

          var colorscale = d3.scale.category10();

                    //Legend titles
                    LegendOptions = LegendOptions.split(";");

                    //Data
                    var d = data;

                    //Options for the Radar chart, other than default
                    var mycfg = {
                      w: w,
                      h: h,
                      maxValue: maxval,
                      levels: 6,
                      ExtraWidthX: 300
                    }

                    //Call function to draw the Radar chart
                    //Will expect that data is in %'s
                    RadarChart.draw("#chart", data, mycfg);

                    ////////////////////////////////////////////
                    /////////// Initiate legend ////////////////
                    ////////////////////////////////////////////

                    var svg = d3.select('#chart')
                    .selectAll('svg')
                    .append('svg')
                    .attr("width", w+300)
                    .attr("height", h)

                    //Create the title for the legend
                    var text = svg.append("text")
                    .attr("class", "title")
                    .attr('transform', 'translate(90,0)') 
                    .attr("x", w - 70)
                    .attr("y", 10)
                    .attr("font-size", "12px")
                    .attr("fill", "#404040")
                    .text("% des HASTAG selon le topique ");

                    //Initiate Legend 
                    var legend = svg.append("g")
                    .attr("class", "legend")
                    .attr("height", 100)
                    .attr("width", 200)
                    .attr('transform', 'translate(90,20)') 
                    ;
                      //Create colour squares
                      legend.selectAll('rect')
                      .data(LegendOptions)
                      .enter()
                      .append("rect")
                      .attr("x", w - 65)
                      .attr("y", function(d, i){ return i * 20;})
                      .attr("width", 10)
                      .attr("height", 10)
                      .style("fill", function(d, i){ return colorscale(i);})
                      ;
                      //Create text next to squares
                      legend.selectAll('text')
                      .data(LegendOptions)
                      .enter()
                      .append("text")
                      .attr("x", w - 52)
                      .attr("y", function(d, i){ return i * 20 + 9;})
                      .attr("font-size", "11px")
                      .attr("fill", "#737373")
                      .text(function(d) { return d; })
                      ; 
                    }

                    </script>

                    <!-- Bootstrap Core JavaScript -->
                    <script src="js/bootstrap.min.js"></script>

                  </body>

                  </html>
