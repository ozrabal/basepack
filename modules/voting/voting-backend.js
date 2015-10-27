var chart = document.getElementById("chart"),
    axisMargin = 15,
    margin = 10,
    valueMargin = 5,
    width = chart.offsetWidth,
    height = chart.offsetHeight,
    barHeight = (height-axisMargin-margin*2)* 0.8/data.length,
    barPadding = (height-axisMargin-margin*2)*0.2/data.length,
    data, bar, svg, scale, xAxis, labelWidth = 0;

max = d3.max(data.map(function(i){
  return i[1];
}));

svg = d3.select(chart)
  .append("svg")
  .attr("width", width)
  .attr("height", 250);

bar = svg.selectAll("g")
  .data(data)
  .enter()
  .append("g");

bar.attr("class", "bar")
  .attr("cx",0)
  .attr("transform", function(d, i) {
     return "translate(" + margin + "," + (i * (barHeight + barPadding) + barPadding) + ")";
  });

bar.append("text")
  .attr("class", "label")
  .attr("y", barHeight / 2)
  .attr("dy", ".35em") //vertical align middle
  .text(function(d){
    return d[0];
  }).each(function() {
    labelWidth = Math.ceil(Math.max(labelWidth, this.getBBox().width));
  });

scale = d3.scale.linear()
  .domain([0, max])
  .range([0, width - margin*2 - labelWidth]);

xAxis = d3.svg.axis()
  .scale(scale)
  .tickSize(-height + 2*margin + axisMargin)
  .orient("bottom");

bar.append("rect")
  .attr("transform", "translate("+labelWidth+", 0)")
  .attr("height", barHeight)
  .attr("width", function(d){
    return scale(d[1]);
  });

bar.append("text")
  .attr("class", "value")
  .attr("y", barHeight / 2)
  .attr("dx", -valueMargin + labelWidth) //margin right
  .attr("dy", ".35em") //vertical align middle
  .attr("text-anchor", "end")
  .text(function(d){
    return d[1];
  })
 .attr("x", function(d){
    var width = this.getBBox().width;
    return Math.max(width + valueMargin, scale(d[1]));
  });

svg.insert("g",":first-child")
 .attr("class", "axis")
 .attr("transform", "translate(" + (margin + labelWidth) + ","+ (height - axisMargin - margin)+")")
 .call(xAxis);