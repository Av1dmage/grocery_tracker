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
      		// instantiates the pie charts, passes in the data and
      		// draws it.
      		function drawChart() {

			var jsonData = $.ajax({
				url: "actions/item_counts.php",
				dataType: "json",
				async: false
			}).responseText;

			var listJsonData = $.ajax({
				url: "actions/list_counts.php",
				dataType: "json",
				async: false
			}).responseText;

			var data = new google.visualization.DataTable(jsonData);
			var listData = new google.visualization.DataTable(listJsonData);
	
        		var options = {
        			'title':'Bought Items',
                	       'width':600,
                       		'height':450
        		};

			var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		 	chart.draw(data, options);
     
			options = {
				'title':'Number of Items in Lists',
				'width':600,
				'height':450
			};

			var listChart = new google.visualization.PieChart(document.getElementById('listChart_div'));
			listChart.draw(listData, options);
		}
    	</script>
  	</head>

  	<body>
	<?php include 'static/navbar.php'; ?>

        <div class="jumbotron">
		<div id="chart_div"></div>

		<div id="listChart_div"></div>
        </div>

	<?php include 'static/footer.php'; ?>

	</body>
</html>
