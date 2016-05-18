<!DOCTYPE html>
<meta charset="utf-8">
<style>

body {
  font: 10px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.browser text {
  text-anchor: end;
}

</style>
<body>
<?php 
include 'connectdb.php';
$mindate = ($conn->query("SELECT min(DATE_TWEET) FROM TWEET;")->fetch_row()[0]);
$maxdate = ($conn->query("SELECT max(DATE_TWEET) FROM TWEET;")->fetch_row()[0]);
$data_text = "date\tnone\tfor\tagainst";
?>
<div id="stackedchart"></div>
<center>
<input type="date" id="dateDeb" value="<?php echo $mindate; ?>"> Date debut
<input type="date" id="dateFin" value="<?php echo $maxdate; ?>"> Date fin
<br/><br/>
<input type="button" id="update" value="Update" onclick="refreshChart();">
<div id="errors"></div>
</center>
<?php
$date = date_create($mindate);

for($i=0; $date < date_create($maxdate) ; $i++)
{
date_add($date, date_interval_create_from_date_string('1 days'));
$datet = date_format($date, 'y-M-d');
$dater = date_format($date, 'Y-m-d');

$total = $conn->query("SELECT COUNT(*) FROM TWEET WHERE DATE_TWEET = '$dater';")->fetch_row()[0];
$none = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'None' AND DATE_TWEET = '$dater';")->fetch_row()[0];
$for_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'For_eu' AND DATE_TWEET = '$dater';")->fetch_row()[0];
$against_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'Against_eu' AND DATE_TWEET = '$dater';")->fetch_row()[0];

$data_text .= "\n".$datet."\t".(100)*intval($none)/intval($total)."\t".(100)*intval($for_eu)/intval($total)."\t".(100)*intval($against_eu)/intval($total);
}

$dfile = fopen("datastack.txt", "w") or die("Unable to open file!");
fwrite($dfile, $data_text);
?>
<script src="//d3js.org/d3.v3.min.js"></script>
<script>

loadChart("datastack.txt");

function refreshChart()
{

document.getElementById("errors").innerHTML = '';

var dated = document.getElementById('dateDeb').value;
var datef = document.getElementById('dateFin').value;
if(dated==''){
	document.getElementById("errors").innerHTML = "date debut est vide";
	return 0;}
var datef = document.getElementById('dateFin').value;
if(datef==''){
	document.getElementById("errors").innerHTML = "date fin est vide";
	return 0;}
if(datef < dated){
	document.getElementById("errors").innerHTML = "date fin doit étre supérieure à date debut";
	return 0;}
sendSAreaData(dated,datef);
}

function sendSAreaData(dated,datef){

xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         loadChart("datastack.txt");
     }
};
xmlhttp.open("POST","getSAreaData.php",true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("dd=" + dated + "&df=" + datef);
}

function loadChart(datafile){

document.getElementById("stackedchart").innerHTML = "";

var margin = {top: 20, right: 20, bottom: 30, left: 50},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var parseDate = d3.time.format("%y-%b-%d").parse,
    formatPercent = d3.format(".0%");

var x = d3.time.scale()
    .range([0, width]);

var y = d3.scale.linear()
    .range([height, 0]);

var color = d3.scale.category20();

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .tickFormat(formatPercent);

var area = d3.svg.area()
    .x(function(d) { return x(d.date); })
    .y0(function(d) { return y(d.y0); })
    .y1(function(d) { return y(d.y0 + d.y); });

var stack = d3.layout.stack()
    .values(function(d) { return d.values; });

var svg = d3.select("#stackedchart").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.tsv(datafile, function(error, data) {
  if (error) throw error;

  color.domain(d3.keys(data[0]).filter(function(key) { return key !== "date"; }));

  data.forEach(function(d) {
    d.date = parseDate(d.date);
  });

  var browsers = stack(color.domain().map(function(name) {
    return {
      name: name,
      values: data.map(function(d) {
        return {date: d.date, y: d[name] / 100};
      })
    };
  }));

  x.domain(d3.extent(data, function(d) { return d.date; }));

  var browser = svg.selectAll(".browser")
      .data(browsers)
    .enter().append("g")
      .attr("class", "browser");

  browser.append("path")
      .attr("class", "area")
      .attr("d", function(d) { return area(d.values); })
      .style("fill", function(d) { return color(d.name); });

  browser.append("text")
      .datum(function(d) { return {name: d.name, value: d.values[d.values.length - 1]}; })
      .attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.y0 + d.value.y / 2) + ")"; })
      .attr("x", -6)
      .attr("dy", ".35em")
      .text(function(d) { return d.name; });

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis);

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis);
});
}
</script>