<?php session_start(); ?>
<html>
<head></head>
<body>

<center> 
	<div id="pieChart"></div><br/>
	<INPUT type="checkbox" id="Against" value="1" checked onclick="refreshPieNorm();"> Against
	<INPUT type="checkbox" id="For" value="2" checked onclick="refreshPieNorm();"> For
	<INPUT type="checkbox" id="None" value="3" checked onclick="refreshPieNorm();"> None
	<br/>
	<input type="date" id="dateDeb" oninput="refreshDatePie();"> Date début
	<input type="date" id="dateFin" oninput="refreshDatePie();"> Date fin
</center>
<br/>

<script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.4.4/d3.min.js"></script>
<script src="d3pie/d3pie.min.js"></script>

<?php

echo "parsing time ".sprintf("%.2f",$_SESSION['exectime'])." secondes<br/><br/>";

?>
<script>

changeDate = 0;

function refreshDatePie(){
	changeDate++;
	if(changeDate > 1){
		var dated = document.getElementById('dateDeb').value;
		var datef = document.getElementById('dateFin').value;
		refreshPieDate(dated,datef);
	}
}

function refreshPieNorm(){

xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         reponse = xmlhttp.responseText;
		 reponses = reponse.split(",");
		 var none = reponses[0];
		 var For = reponses[1];
		 var against = reponses[2];
		 loadPie(against,For,none);
     }
};
xmlhttp.open("GET","getPieData.php",true);
xmlhttp.send();

}

function refreshPieDate(dd,df){

xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         reponse = xmlhttp.responseText;
		 reponses = reponse.split(",");
		 var none = reponses[0];
		 var For = reponses[1];
		 var against = reponses[2];
		 loadPie(against,For,none);
     }
};
xmlhttp.open("GET","getPieData.php?dd=" + dd + "&df=" + df,true);
xmlhttp.send();
}

function loadPie(nagainst,nfor,nnone){

if (!document.getElementById('Against').checked) { nagainst = 0;};
if (!document.getElementById('For').checked) {nfor = 0;};
if (!document.getElementById('None').checked) {nnone = 0;}

document.getElementById("pieChart").innerHTML = "";

var pie = new d3pie("pieChart", {
	"header": {
		"title": {
			"text": "UK EU Referendum",
			"fontSize": 24,
			"font": "open sans"
		},
		"subtitle": {
			"text": "Number of tweets: " + (parseInt(nnone)+parseInt(nfor)+parseInt(nagainst)),
			"color": "#999999",
			"fontSize": 12,
			"font": "open sans"
		},
		"titleSubtitlePadding": 9
	},
	"footer": {
		"color": "#999999",
		"fontSize": 10,
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
				"value": parseInt(nfor) ,
				"color": "#7d9058"
			},
			{
				"label": "Against",
				"value": parseInt(nagainst),
				"color": "#44b9b0"
			},
			{
				"label": "None",
				"value": parseInt(nnone),
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