<?php
	include("predlosci/zaglavlje.php");
	include("baza.php");

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
		
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

		<link href="adolenec.css" rel="stylesheet" type="text/css">
    </head>
	
	<body>

		<h1>Korisnici</h1>
			<table width = "550px" height = "50px" border="2" >
				<tr bgcolor="#5f9ea0">
					<td>Prezime</td>
					<td>Ime</td>
					<td>Kor. ime</td>
					<td></td>
					<td></td>
				</tr>
				<?php
					$sql="SELECT korisnik_id, ime, prezime, korime FROM korisnik ORDER BY prezime ASC";
					$rs=izvrsiUpit($veza, $sql);
					if(mysqli_num_rows($rs)==0)$greska="Nema rezultata za postavljeni upit!";
					else{
						while(list($id, $ime, $prezime, $korime)=mysqli_fetch_array($rs)) {
							echo "<tr>
								<td>$prezime</td>
								<td>$ime</td>
								<td>$korime</td>
								<td><a class='link' href='korisnik.php?korisnik=$id'>DETALJI</a></td>
								<td><a class='link' href='korisnik.php?korisnik=$id&uredi=1'>UREDI</a></td>
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