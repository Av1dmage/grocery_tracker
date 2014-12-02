<HTML>
<head>
  <?php include 'static/includes.php';?>
</head>

<?php include "static/navbar.php";?>

<body>

<div class='jumbotron pad-text'>
<form method="get" action="actions/update_names.php" method="get">
    <h4>Update Names:</h4>
   <ul id="itemList">
   <?php
     foreach($_GET as $i) {
       Print("<li><b>$i:</b>&nbsp<input type=text, name='$i'/></li>\n");
     }      
   ?>
   </ul>
   <input type="submit" value="Save"/>
</form>
</div>
<?php include "static/footer.php";?>

</body>
<HTML>
