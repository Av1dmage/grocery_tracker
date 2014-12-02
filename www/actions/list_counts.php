<?php
//PHP API that returns JSON for specific mysql query results.

include "../static/db_info.php";

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
  die('{"Error":"'.$conn->connect_error.'"}');
}

function itemCount($conn) {
  //returns json list of item names and their individual counts
  $sql = "SELECT c, COUNT(c) FROM (SELECT COUNT(time) AS c FROM ListItems GROUP BY time) AS A GROUP BY c";
  $result = $conn->query($sql);
  if(!$result) {
    die('{"Error":"'.mysqli_error($conn).'"}');
  }
  if($result->num_rows == 0) {
    die('{"Error": "No Results."}');
  }
	
	$cols = array(
		array('label' => 'c', 'type' => 'string'),
		array('label' => 'COUNT(c)', 'type' => 'number')
	);

  $rows = array();
  while($row = $result->fetch_assoc()) {
		$row = array('c' => array(array('v' => $row["c"]), array('v' => (int) $row["COUNT(c)"]))); 
		array_push($rows, $row);
  }

	$results = array(
		'cols' => $cols,
		'rows' => $rows
	);
	
	echo json_encode($results);

}

itemCount($conn);
?>
