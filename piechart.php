<html>
<head></head>
<body>

<center><div id="pieChart"></div></center>

<script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.4.4/d3.min.js"></script>
<script src="d3pie/d3pie.min.js"></script>
<?php

include 'connectdb.php';

$none = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET LIKE 'None'")->fetch_row()[0];
$for_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET LIKE 'For_eu'")->fetch_row()[0];
$against_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET LIKE 'Against_eu'")->fetch_row()[0];

?>
<script>
var pie = new d3pie("pieChart", {
	"header": {
		"title": {
			"text": "UK EU Referendum",
			"fontSize": 24,
			"font": "open sans"
		},
		"subtitle": {
			"text": "Number of tweets: " + <?php echo ($none+$for_eu+$against_eu); ?>,
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
				"value": <?php echo $for_eu;  ?>,
				"color": "#7d9058"
			},
			{
				"label": "Against",
				"value": <?php echo $against_eu; ?>,
				"color": "#44b9b0"
			},
			{
				"label": "None",
				"value": <?php echo $none;?>,
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
</script>

</body>
</html>