<html>
  <head>
		<title>Stats</title>
		<?php include 'static/includes.php';?>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

				var jsonData = $.ajax({
					url: "actions/item_counts.php",
					//data: "q="+num,
					dataType: "json",
					async: false
				}).responseText;

				var data = new google.visualization.DataTable(jsonData);
	
        // Set chart options
        var options = {'title':'Bought Items',
                       'width':600,
                       'height':450};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
		<?php include 'static/navbar.php'; ?>

    <div id="chart_div"></div>

		<?php include 'static/footer.php'; ?>

	</body>
</html>
