<?php
  Print json_encode($_GET)."<br/>";

  include "db_info.php";

  $conn = new mysqli($hostname, $username, $password, $database);
  if ($conn->connect_error) {
    die("Unable to connect to MySQL: ".$conn->connect_error);
  }

  $sql = "INSERT INTO Lists() VALUES ()";
  $stmt = $conn->prepare($sql);
  if(!$stmt->execute()){
    die("Unable to insert new list: ".mysqli_error($conn));
  }

  $sql = "SELECT * FROM Lists ORDER BY time desc limit 1";
  $stmt = $conn->prepare($sql);
  if(!$stmt->execute()){
    die("Unable retrieve list timestamp: ".mysqli_error($conn));
  }
  //$result = $stmt->get_result();
  //if(!$result) {
    //die("Unable retrieve list timestamp (empty result): ".mysqli_error($conn));
  //}
 //$result->fetch_array(MYSQLI_NUM);



  foreach($_GET as $i) {
    Print $i."<br/>";
  }

  
?>
