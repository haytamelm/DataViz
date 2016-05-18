<?php 
session_start(); 
include 'connectdb.php';
$mindate = ($conn->query("SELECT min(DATE_TWEET) FROM TWEET;")->fetch_row()[0]);
$maxdate = ($conn->query("SELECT max(DATE_TWEET) FROM TWEET;")->fetch_row()[0]);
?>
<html>
<head>
	<style>
	#errors
	{
		color: red;
	}
	</style>
</head>
<body>

<center> 
	<div id="pieChart"></div>
	<br/>
	<INPUT type="checkbox" id="Against" checked > Against
	<INPUT type="checkbox" id="For" checked > For
	<INPUT type="checkbox" id="None" checked > None
	<br/>
	<input type="date" id="dateDeb" 
	value="<?php echo $mindate; ?>"> Date début
	<input type="date" id="dateFin" 
	value="<?php echo $maxdate; ?>"> Date fin
	<br/><br/>
	<input type="button" id="update" value="Update" onclick="refreshPie();">
	<div id="errors"></div>
</center>
<br/>

<script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.4.4/d3.min.js"></script>
<script src="d3pie/d3pie.min.js"></script>

<script>

document.getElementById("update").click();

function refreshPie(){
	document.getElementById("errors").innerHTML = '';
	var dated = document.getElementById('dateDeb').value;
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
	nbChoixCoches = 0;
	var qfor=0,qagainst=0,qnone=0;
	if (document.getElementById('Against').checked) { nbChoixCoches++; qagainst=1; }
	if (document.getElementById('For').checked) { nbChoixCoches++; qfor=1; }
	if (document.getElementById('None').checked) { nbChoixCoches++; qnone=1; }
	if(nbChoixCoches < 2 ){
	   document.getElementById("errors").innerHTML = 'cochez au moins 2 choix';
	   return 0;
	}
	sendPieData(dated,datef,qfor,qagainst,qnone);
}

function sendPieData(dated,datef,qfor,qagainst,qnone){

xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         reponse = xmlhttp.responseText;
		 reponses = reponse.split(",");
		 console.log(reponses);
		 var numNone = reponses[0];
		 var numFor = reponses[1];
		 var numAgainst = reponses[2];
		 loadPie(numNone,numFor,numAgainst);
     }
};
xmlhttp.open("POST","getPieData.php",true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("qfor=" + qfor + "&qagainst=" + qagainst + "&qnone=" + qnone + "&dd=" + dated + "&df=" + datef);
}

function loadPie(numNone,numFor,numAgainst){

document.getElementById("pieChart").innerHTML = "";

var pie = new d3pie("pieChart", {
	"header": {
		"title": {
			"text": "UK EU Referendum",
			"fontSize": 24,
			"font": "open sans"
		},
		"subtitle": {
			"text": "Number of tweets: " + (parseInt(numNone)+parseInt(numFor)+parseInt(numAgainst)),
			"color": "#999999",
			"fontSize": 13,
			"font": "open sans"
		},
		"titleSubtitlePadding": 9
	},
	"footer": {
		"color": "#999999",
		"fontSize": 14,
		"font": "open sans",
		"location": "bottom-left"
	},
	"size": {
		"canvasWidth": 590,
		"pieOuterRadius": "90%"
	},
	"data": {
		"sortOrder": "value-desc",
		"content": [
			{
				"label": "For",
				"value": parseInt(numFor) ,
				"color": "#7d9058"
			},
			{
				"label": "Against",
				"value": parseInt(numAgainst),
				"color": "#44b9b0"
			},
			{
				"label": "None",
				"value": parseInt(numNone),
				"color": "#7c37c0"
			}
		]
	},
	"labels": {
		"outer": {
			"pieDistance": 32
		},
		"inner": {
			"hideWhenLessThanPercentage": 3
		},
		"mainLabel": {
			"fontSize": 11
		},
		"percentage": {
			"color": "#ffffff",
			"decimalPlaces": 0
		},
		"value": {
			"color": "#adadad",
			"fontSize": 11
		},
		"lines": {
			"enabled": true
		},
		"truncation": {
			"enabled": true
		}
	},
	"effects": {
		"pullOutSegmentOnClick": {
			"effect": "linear",
			"speed": 400,
			"size": 8
		}
	},
	"misc": {
		"gradient": {
			"enabled": true,
			"percentage": 100
		}
	}
});
}
</script>

</body>
</html>