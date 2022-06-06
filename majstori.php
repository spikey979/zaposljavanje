<?php
     include("predlosci/zaglavlje.php");
	 include_once("baza.php");
	 include("helpers.php");

	if(session_id()=="")session_start();

	if($_SESSION['aktivni_korisnik_tip'] == NULL) {
		echo "<script> location.href='obavijest.php?poruka=Niste prijavljeni kao korisnik!'; </script>";
		exit();
	} else if($_SESSION['aktivni_korisnik_tip'] > 0) {
		echo "<script> location.href='obavijest.php?poruka=Nemate potrebne ovlasti za traženi pregled!'; </script>";
	}

	$veza=spojiSeNaBazu();
?>

<!DOCTYPE html>
<html>
    <head>
<title>Zapošljavanje majstora</title>
		<meta charset="utf-8" />
		<meta name="autor" content="Ana Dolenec" />
		<meta name="datum" content="28.05.2022." />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="adolenec.css" rel="stylesheet" type="text/css">

   </head>
   <body>
		
		<h1>Majstori</h1>
			<table width = "550px" height = "50px" border="2" >
				<tr bgcolor="#5f9ea0">
					<td>Ime</td>
					<td>Prezime</td>
					<td>Zanimanje</td>
				</tr>
				<?php
					$sql="SELECT ime, prezime, zanimanje_id FROM korisnik WHERE tip_korisnika_id = 1";
					$rs=izvrsiUpit($veza, $sql);
					if(mysqli_num_rows($rs)==0)$greska="Nema rezultata za postavljeni upit!";
					else{
						while(list($ime, $prezime, $zanimanje_id)=mysqli_fetch_array($rs)) {
							printf("<tr><td>%s</td><td>%s</td><td>%s</td</tr>",  $ime, $prezime, $zanimanje_id);
						}
					}
				?>
 			</table>
	
    </body>

</html>

<?php
     include("predlosci/podnozje.php");
?>