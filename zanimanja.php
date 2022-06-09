<?php
	include("predlosci/zaglavlje.php");
	include("baza.php");
	//include "helpers.php";

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
		<title>Zaposljavanje majstora</title>
		<meta charset="utf-8" />
		<meta name="autor" content="Ana Dolenec" />
		<meta name="datum" content="28.05.2022." />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="/../adolenec.css" rel="stylesheet" type="text/css">
    </head>

	<body>

		<h1>Zanimanja</h1>
		<div>
			<a class='link' href='zanimanje.php?zanimanje=$id&dodaj=1'>Dodaj novo zanimanje</a>
		</div>

		<div>
			<table width = "700px" height = "50px" border="2" >
				<tr bgcolor="#5f9ea0">
					<td>Naziv</td>
					<td>Opis</td>
					<td></td>
					<td></td>
				</tr>
				<?php
				 	$sql="SELECT zanimanje_id, naziv, opis FROM zanimanje ORDER BY naziv ASC";
					$rs=izvrsiUpit($veza, $sql);
					if(mysqli_num_rows($rs)==0)$greska="Nema rezultata za postavljeni upit!";
					else{
						while(list($id, $naziv, $opis)=mysqli_fetch_array($rs)) {
							echo "<tr>
								<td>$naziv</td>
								<td>$opis</td>
								<td><a class='link' href='zanimanje.php?zanimanje=$id&uredi=1'>UREDI</a></td>
								<td><a class='link' href='zanimanje.php?zanimanje=$id&obrisi=1'>OBRIŠI</a></td>
							";
							echo "</tr>";
						}
					}
				?>
 			</table>

		</div>
	</body>
</html>

<?php
     include("predlosci/podnozje.php");
?>