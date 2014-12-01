<!DOCTYPE HTML>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />

  <title>Grocery List</title>

  <script type="text/javascript" charset="utf-8">
    function onLoad() {
      // initialize itemCount
      window.itemCount = 0; 
      addItem();
    }

    function addItem() {
      var ul = document.getElementById("itemList");
      var li = document.createElement("li");

      // Create new input li to append to list.
      var input = document.createElement("input");
      input.setAttribute("type", "text");
      input.setAttribute("name", "item" + String(window.itemCount));
      input.setAttribute("id"  , "item" + String(window.itemCount));
      input.setAttribute("onblur" , "validateUPC('" + "item" + String(window.itemCount) + "')");

      // Append new li to list
      li.appendChild(input);
      ul.appendChild(li);

      window.itemCount = window.itemCount + 1;
    }

    function validateUPC(id) {
      var reupc = /^[0-9]{12}$/
      var input = document.getElementById(id);

      if(!input.value.match(reupc)) {
        alert("Error: UPCs must be 12 characters in length, and contain only numbers. e.g. '123123123123'.");
        input.setAttribute("style" , "color: red;");
      } else {
        input.setAttribute("style" , "");
      }
    }

    window.onload = onLoad;
  </script>

  <?php include 'static/includes.php';?>
</head>

<html>

  <?php
    include 'static/navbar.php';
  ?>
  
  <h4><b>Enter UPCs:</b></h4>
  <form method="get" action="actions/save_list.php">
     <ul id="itemList">
     </ul>
     <input type="button" onclick="addItem()" value="+"/>
     <input type="submit" value="Save"/>
  </form>

  <?php
    include 'static/footer.php';
  ?>

</html>
