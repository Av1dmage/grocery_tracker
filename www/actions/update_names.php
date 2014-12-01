<?php
  //Print(json_encode($_GET));

  include "db_info.php";

  $conn = new mysqli($hostname, $username, $password, $database);
  if ($conn->connect_error) {
    die("Unable to connect to MySQL: ".$conn->connect_error);
  }
  
  foreach($_GET as $key => $value) {
    $upc = $conn->real_escape_string($key);
    $name = $conn->real_escape_string($value);
    $sql = "UPDATE Items SET name='$name' WHERE upc='$upc'";

    $result = $conn->query($sql);
    if($conn->affected_rows == 0) {
      die("Unable add name '$name' for upc '$upc': ".mysqli_error($conn));
    }
  }

  $url = "../index.php";
?>

<HTML>
<script type="text/javascript">
   window.location = "<?php Print $url; ?>";
</script>
</HTML>

