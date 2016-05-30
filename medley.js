  var width = 1200,
      height = 600;
  var fill = d3.scale.category20b();

  d3.tsv("word-cloud.tsv", function(data){
    var leaders = data
      .map(function(d){ return {text: d.Name, size: +d.G};})
      .sort(function(a,b){ return d3.descending(a.size,b.size);});

    d3.layout.cloud().size([width, height])
        .words(leaders)
        .rotate(function() { return ~~(Math.random() * 2) * 90; })
        .font("Impact")
        .fontSize(function(d) { return d.size; })
        .on("end", draw)
        .start();
  });

  function draw(words) {
    d3.select("#word-cloud").append("svg")
        .attr("width", width)
        .attr("height", height)
      .append("g")
        .attr("transform", "translate("+(width/2)+","+(height/2)+")")
      .selectAll("text")
        .data(words)
      .enter().append("text")
        .style("font-size", function(d) { return (d.size) + "px"; })
        .style("font-family", "Impact")
        .style("fill", function(d, i) { return fill(i); })
        .attr("text-anchor", "middle")
        .attr("transform", function(d) {
          return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
        })
        .text(function(d) { return d.text; });
  }