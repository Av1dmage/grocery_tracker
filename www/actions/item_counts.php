<?php
//PHP API that returns JSON for specific mysql query results.

include "../static/db_info.php";

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
  die('{"Error":"'.$conn->connect_error.'"}');
}

function itemCount($conn) {
  //returns json list of item names and their individual counts
  $sql = "SELECT i.name as name,count(l.upc) as count FROM ListItems l JOIN Items i ON (l.upc=i.upc) GROUP BY name ORDER BY count(l.upc) desc";
  $result = $conn->query($sql);
  if(!$result) {
    die('{"Error":"'.mysqli_error($conn).'"}');
  }
  if($result->num_rows == 0) {
    die('{"Error": "No Results."}');
  }
	
	$cols = array(
		array('label' => 'name', 'type' => 'string'),
		array('label' => 'count', 'type' => 'number')
	);

  $rows = array();
  while($row = $result->fetch_assoc()) {
		$row = array('c' => array(array('v' => $row["name"]), array('v' => (int) $row["count"]))); 
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
