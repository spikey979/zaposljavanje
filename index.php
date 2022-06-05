<?php


?>

<!DOCTYPE html>
<html>
     <head>
          <title>Zaposljavanje majstora</title>
          <meta charset="utf-8" />
          <meta name="autor" content="Ana Dolenec" />
          <meta name="datum" content="28.05.2022." />
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          
          <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

          <link href="adolenec.css" rel="stylesheet" type="text/css">
     </head>

     <body>
          <div id="zaglavlje"></div>
          <script>
               $(function() { $("#zaglavlje").load("/predlosci/zaglavlje.php"); });
          </script>
              
          <p>Dobro došli u sustav za zapošljavanje majstora!<br><br>Ovdje možete ugovoriti posao sa majstorom.</p>

          <div id="podnozje"></div>
          <script>
               $(function() { $("#podnozje").load("/predlosci/podnozje.html"); });
          </script>
     </body>
</html>
