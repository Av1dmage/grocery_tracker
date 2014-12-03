<!DOCTYPE HTML>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />

  <title>Grocery Tracker</title>

  <script type="text/javascript">
    var _GET = {};
    var json = "";
    var n = 0;

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

      httpGetLists(setJson);
    }

    function updateList() {
      var lists = JSON.parse(json);
      if( n <= 0) {
        n = 0;
      }
      if( n >= lists.length) {
        n = lists.length - 1;
      }

      var div = document.getElementById("list");
      div.innerHTML = "";

      var title = document.getElementById("listTitle");

      title.innerHTML = "List " + String(n) + " (" + String(lists[n]["time"]) + "):";

      var ul = document.createElement("ul");
      ul.setAttribute("style", "padding-left: 10px;");
      ul.setAttribute("class", "list-group");

      var items = lists[n]["items"];
      for(var i = 0; i < items.length; i++) {
        var li = document.createElement('li');
        li.innerHTML = String(items[i]);
        li.setAttribute("class", "list-group-item");
        ul.appendChild(li);
      }

      div.appendChild(ul);
    }

    function nextList() {
      n = n + 1;
      updateList();
    }

    function prevList() {
      n = n - 1;
      updateList();
    }

    function setJson(j) {
      json = j;
      updateList(n);
    }

    function httpGetLists(callback) {
      var url = "http://digitalstuff.me/grocery_tracker/actions/get_lists.php";
      var xhr = new XMLHttpRequest();
      xhr.open("GET", url, true, 'groceries', 'groceries');
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
    <div class="panel panel-default">
      <div class="panel-body">
        <h3 style="padding-left: 10px;">View Lists</h3>
        <form style="padding-left: 10px;">
           <input type='button' onclick="javascript:prevList()" value='<'/>
           <input type='button' onclick="javascript:nextList()" value='>'/>
        </form>
      </div>
    </div>
    <br/>
    <br/>
    <br/>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 id="listTitle" class="panel-title"></h3>
      </div>
      <div class="panel-body">
        <div id=list>
        </div>
      </div>
    </div>
  </div>

  <?php
    include 'static/footer.php';
  ?>

</body>
