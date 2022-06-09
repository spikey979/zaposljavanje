<?php
    include("predlosci/zaglavlje.php");
	include_once("baza.php");
	
	if(session_id()=="")session_start();

	$veza=spojiSeNaBazu();
?>

<!DOCTYPE html>
<html>
	<head>
          <title>Zaposljavanje majstora</title>
          <meta charset="utf-8" />
          <meta name="autor" content="Ana Dolenec" />
          <meta name="datum" content="28.05.2022." />
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
		  
          <link href="adolenec.css" rel="stylesheet" type="text/css">
		          		  
     </head>
	<body>
	
	<h1>Galerija slika</h1>
	
       <table style="border-spacing:0; margin-left: auto; margin-right: auto; text-alignt:" center>
			
		<?php
			$sql="SELECT DISTINCT slika FROM slika ORDER BY datum_vrijeme_postavljanja DESC";
			$rs=izvrsiUpit($veza, $sql);
			if (isset($rs)){			  
				while($rows = mysqli_fetch_array($rs)) {
					if(!isset($SESSION["tip"])){
                        echo"<tr>";
                        echo'<td><img src=' . $rows["slika"] .' height="400" width="600" ></td>';
                        echo"</tr>";
					}
					if(!isset($SESSION["tip"])){
                        echo"<tr>";
                        echo"<td></td>";
                        echo"</tr>";
					}
				}	
			}
		?>

		</table>
		
		
	</body>
</html>

<?php
     include("predlosci/podnozje.php");
?>