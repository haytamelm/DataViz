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