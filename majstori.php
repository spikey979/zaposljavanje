<?php
     include("predlosci/zaglavlje.php");
	 include_once("baza.php");
	 include("helpers.php");

	if(session_id()=="")session_start();

	if($_SESSION['aktivni_korisnik_tip'] == NULL) {
		echo "<script> location.href='obavijest.php?poruka=Niste prijavljeni kao korisnik!'; </script>";
		exit();
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
			<table width = "550px" height = "50px" border="2" align="center" >
				<tr bgcolor="#1ca372">
					<td align="center"><strong>Prezime</strong></td>
					<td align="center"><strong>Ime</strong></td>
					<td align="center"><strong>Zanimanje</strong></td>
					<td></td>
				</tr>
				<?php
					$sql="SELECT korisnik_id, ime, prezime, zanimanje_id FROM korisnik WHERE tip_korisnika_id = 1 ORDER BY prezime ASC";
					$rs=izvrsiUpit($veza, $sql);
					if(mysqli_num_rows($rs)==0)$greska="Nema rezultata za postavljeni upit!";
					else{
						while(list($id, $ime, $prezime, $zanimanje_id)=mysqli_fetch_array($rs)) {
							$zanimanje_naziv = "nepoznato";
							$sql="SELECT naziv FROM zanimanje WHERE zanimanje_id ='$zanimanje_id'";
							$rs_1=izvrsiUpit($veza, $sql);
							if(mysqli_num_rows($rs_1)==0)$greska="Nema rezultata za postavljeni upit!";
							else {
								list($zanimanje_naziv)=mysqli_fetch_array($rs_1);
							}

							echo "<tr>
								<td>$prezime</td>
								<td>$ime</td>
								<td>$zanimanje_naziv</td>
								<td><a class='link' href='majstor.php?majstor=$id'>DETALJI</a></td>
							";
							echo "</tr>";

						}
					}
				?>
 			</table>
	
    </body>

</html>

<?php
     include("predlosci/podnozje.php");
?>
