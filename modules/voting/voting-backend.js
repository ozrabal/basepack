!function ($) {
  var
      chart,
      width = 800,
      bar_height = 50,
      height = bar_height * chart_data.names.length;
var left_width = 10;
  /* step 1 */
  chart = d3.select($("#voting-results")[0])
    .append('svg')
    .attr('class', 'chart')
    .attr('width', width)
    .attr('height', height);

var x, y;
x = d3.scale.linear()
   .domain([0, d3.max(chart_data.scores)])
   .range([0, width]);

y = d3.scale.ordinal()
   .domain(chart_data.scores)
   .rangeBands([0, height]);

chart.selectAll("rect")
   .data(chart_data.scores)
   .enter().append("rect")
   .attr("x", 0)
   .attr("y", y)
   .attr("width", x)
   .attr("height", y.rangeBand());

chart.selectAll("text.score")
  .data(chart_data.scores)
  .enter().append("text")
  .attr("x", function(d) { return x(d) ; })
  .attr("y", function(d){ return y(d) + y.rangeBand()/2; } )
  .attr("dx", -5)
  .attr("dy", ".36em")
  .attr("text-anchor", "end")
  .attr('class', 'score')
  .text(String);

chart.selectAll("text.name")
  .data(chart_data.names)
  .enter().append("text")
  .attr("x", left_width / 2)
  .attr("y", function(d, i){ return y(chart_data.scores[i]) + y.rangeBand()/2; } )
  .attr("dy", ".36em")
  .attr("text-anchor", "start")
  .attr('class', 'name')
  .text(String);


}(window.jQuery);

