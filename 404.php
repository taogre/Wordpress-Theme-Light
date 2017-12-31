<!DOCTYPE HTML>
<html>
  <head>
    <title>404 Page not found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <style>
      html,body{
        margin: 0px;
        padding: 0px;
      }
      *{
        font-family: sans-serif;
        box-sizing: border-box;
      }
      #container{
        display: table;
        position: absolute;
        width: 100%;
        height: 100%;
      }
      #container > div{
        display: table-cell;
        vertical-align: middle;
      }
      h1{
        text-align: center;
        font-size: 10em;
        margin: 5px 0px;
        color: #36bcef;
      }
      p{
        text-align: center;
        font-size: 1.2em;
        margin: 0px;
      }
      p a{
        color: #258fb7;
      }
    </style>
  </head>
  <body>
    <div id="container">
      <div>
        <h1>404</h1>
        <p>Zurück auf <a href="/" id="backlink"></a></p>
      </div>
    </div>
    <script>
      var url = window.location.href;
      url = url.replace('http://','').replace('https://','').split('/')[0];
      document.getElementById("backlink").innerHTML = url;
    </script>
  </body>
</html>
