<?php
//PHP Script that returns all of the lists and their items

include "../static/db_info.php";

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
  die('{"Error":"'.$conn->connect_error.'"}');
}

function getLists($conn) {
  //return a json object containing all of the lists
  $sql = "SELECT * FROM Lists";
  $lists_results = $conn->query($sql);
  if(!$lists_results) {
    die('{"Error":"'.mysqli_error($conn).'"}');
  }
  if($lists_results->num_rows == 0) {
    die('{"Error": "No Results."}');
  }

  $alllists = array();
  while($row = $lists_results->fetch_assoc()) {
    $timestamp = $row["time"];
    $list = array();
    $list["time"] = $timestamp;
    $sql = "SELECT * FROM ListItems JOIN Items ON (ListItems.upc=Items.upc) WHERE time='$timestamp'";
    $result = $conn->query($sql);
    if(!$result) {
      die('{"Error":"'.mysqli_error($conn).'"}');
    }
    //Since it's technically possible to have a list with no items right now...
    //if($result->num_rows == 0) {
    //  die('{"Error": "No Results."}');
    //}

    $itemlist = array();
    while($row = $result->fetch_assoc()) {
      array_push($itemlist, $row["name"]);
    }
    if(count($itemlist) == 0) {
      continue;
    }

    $list["items"] = $itemlist; 
    array_push($alllists, $list);
  }

  print(json_encode($alllists));
}

getLists($conn);
?>
