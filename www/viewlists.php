<!DOCTYPE HTML>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />

  <title>Grocery Tracker</title>

  <script type="text/javascript">
    var _GET = {};

    function init() {
      if(document.location.toString().indexOf('?') !== -1) {
          var query = document.location
                         .toString()
                         // get the query string
                         .replace(/^.*?\?/, '')
                         // and remove any existing hash string (thanks, @vrijdenker)
                         .replace(/#.*$/, '')
                         .split('&');

          for(var i=0, l=query.length; i<l; i++) {
             var aux = decodeURIComponent(query[i]).split('=');
             _GET[aux[0]] = aux[1];
          }
      }

      setFormActions();

      httpGetLists(updateList)
    }

    function setFormActions() {
      //not updating GET?
      var next_n = document.getElementById("n");
      var m = 0;
      var n = 0;
      var o = 0;
 
      if(_GET["n"]) {
        n = Number(_GET["n"]);
        o = n + 1;
        m = n - 1;
      }
      alert(n);
      //alert(String(o));

      next_n.setAttribute("value", String(o));
    }

    function updateList(json) {
      var div = document.getElementById("list");
      var ul = document.createElement("ul");
      lists = JSON.parse(json);
      
      var n = 0;
      if(_GET["n"]) {
        n = Number(_GET["n"]);
      }

      var items = lists[n]["items"];
      for(var i = 0; i < items.length; i++) {
        var li = document.createElement('li');
        li.innerHTML = String(items[i]);
        ul.appendChild(li);
      }

      div.appendChild(ul);
    }

    function httpGetLists(callback) {
      var url = "http://localhost/grocery_list/actions/get_lists.php";
      var xhr = new XMLHttpRequest();
      xhr.open("GET", url, true);
      xhr.onload = function (e) {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            //console.log(xhr.responseText);
            callback(xhr.responseText);
          } else {
            console.error(xhr.statusText);
          }
        }
      };
      xhr.onerror = function (e) {
        console.error(xhr.statusText);
      };
      xhr.send(null);
    }
  </script>

  <?php include 'static/includes.php';?>
</head>

<body onload='init()'>

  <?php
    include 'static/navbar.php';
  ?>

  <div class='jumbotron'>
    <div id=list>
    </div>
    <form id='next' action='viewlists.php' method='get'>
       <input id='n' value='0' type='hidden'>
       <input type='submit' value='>'/>
    </form>
  </div>

  <?php
    include 'static/footer.php';
  ?>

</body>
