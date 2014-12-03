<?php

  include "../static/db_info.php";

  function revert_changes($timestamp, $conn) {
    //Hypothetically reverts changes made to the database if some part of process is unsuccessful.
  };

  $conn = new mysqli($hostname, $username, $password, $database);
  if ($conn->connect_error) {
    die("Unable to connect to MySQL: ".$conn->connect_error);
  }

  //Create a new list timestamp
  $sql = "INSERT INTO Lists() VALUES ()";
  $result = $conn->query($sql);
  if(!$result){
    die("Unable to insert new list: ".mysqli_error($conn));
  }

  //Get the new list timestamp
  $sql = "SELECT * FROM Lists ORDER BY time desc limit 1";
  $result = $conn->query($sql);
  if(!$result) {
    die("Unable retrieve list timestamp (empty result): ".mysqli_error($conn));
  }
  $timestamp = $result->fetch_array(MYSQLI_NUM)[0];

  //Insert the items on the list
  $noname = array();
  foreach($_GET as $i) {
    $upc = mysqli_real_escape_string($conn, $i);
    if(!preg_match('/^\d{12}$/', $upc)) {
      die("Malformed UPC: '$upc'. Aborting.");
      revert_changes($timestamp, $conn);
    }

    //Check UPC/Name in database
    $sql = "SELECT * FROM Items WHERE upc='$upc'";
    $result = $conn->query($sql);
    if(!$result) {
      die("Unable to search Items for $upc: ".mysqli_error($conn));
      revert_changes($timestamp, $conn);
    }
    if($result->num_rows == 0) {
      //Add item if it doesn't exist
      $sql = "INSERT INTO Items(upc) VALUES ('$upc')";
      $result = $conn->query($sql);
      if($conn->affected_rows == 0) {
        die("Unable to insert $upc into Items: ".mysqli_error($conn));
        revert_changes($timestamp, $conn);
      }
    }

    //Update name if needed
    $sql = "SELECT * FROM Items WHERE upc='$upc'";
    $result = $conn->query($sql);
    if(!$result) {
      die("Unable to search Items for item name for $upc: ".mysqli_error($conn));
      revert_changes($timestamp, $conn);
    }
    if($result->num_rows == 0) {
      die("No rows returned for item name lookup on $upc: ".mysqli_error($conn));
      revert_changes($timestamp, $conn);
    }
    $row = $result->fetch_assoc();
    if(!$row["name"]) {
      //Push to list of items that have no name
      array_push($noname, $row["upc"]);
    }
    
    //Insert into list
    $sql = "INSERT INTO ListItems (time, upc) VALUES ('$timestamp','$upc')";
    $result = $conn->query($sql);
    if($conn->affected_rows == 0) {
      die("Unable to insert ($timestamp, $upc) into ListItems: ".mysqli_error($conn));
      revert_changes($timestamp, $conn);
    }
  }
  
  $conn->close();

  if(count($noname) == 0) {
    $url = "../index.php";
  } else {
    $url = "../namesform.php?";
    $c = 0;
    foreach($noname as $i) {
      if($c != 0) {
        $url = $url."&";
      }
      $url = $url."upc$c=$i";
      $c = $c + 1;
    }
  }

?>
<HTML>
<script type="text/javascript">
   window.location = "<?php Print $url; ?>";
</script>
</HTML>
