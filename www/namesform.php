<HTML>
<head>
  <?php include 'includes.php';?>
</head>

<?php include "navbar.php";?>

<body>
<form method="get" action="actions/save_list.php">
    <h4>Update Names:</h4>
   <ul id="itemList">
   <?php
     foreach($_GET as $i) {
       Print("<li>$i</li>\n");
     }      
   ?>
   </ul>
   <input type="submit" value="Save"/>
</form>
</body>

<?php include "footer.php";?>
<HTML>
