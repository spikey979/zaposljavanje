<?php
	include("predlosci/zaglavlje.php");
	include("baza.php");

	if(session_id()=="")session_start();

	if(!isset($_SESSION['aktivni_korisnik_tip']) || $_SESSION['aktivni_korisnik_tip'] == NULL) {
		echo "<script> location.href='obavijest.php?poruka=Niste prijavljeni kao korisnik!'; </script>";
		exit();
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
		
		<link href="adolenec.css" rel="stylesheet" type="text/css">
    </head>
	
	<body>

		<h1>Korisnici</h1>
		<!--<div>
			<?php
				if($_SESSION['aktivni_korisnik_tip'] == 0) { //novog korisnika može dodati samo admin
					echo "<a class='link' href='korisnik.php?korisnik=1&dodaj=1'>Dodaj novog korisnika</a>";
				}
			?>
		</div>-->
			<table width = "700px" height = "50px" border="2" align="center" >
				<tr bgcolor="#1ca372">
					<td align="center"><strong>Prezime</strong></td>
					<td align="center"><strong>Ime</strong></td>
					<td align="center"><strong>Korisničko ime</strong></td>
					<td colspan="3" align="center"><?php
				if($_SESSION['aktivni_korisnik_tip'] == 0) { //novog korisnika može dodati samo admin
					echo "<a class='link' href='korisnik.php?korisnik=1&dodaj=1'>DODAJ NOVOG KORISNIKA</a>";
				}
			?></td>
					
				</tr>
				<?php
				 	if($_SESSION['aktivni_korisnik_tip'] > 0) { //ako korisnik nije administrator, prikaži samo njega
						$tmp_id = $_SESSION["aktivni_korisnik_id"];
						$sql="SELECT korisnik_id, ime, prezime, korime FROM korisnik WHERE korisnik_id=$tmp_id";
					 } else { //ako je admin, prikaži sve korisnike
						$sql="SELECT korisnik_id, ime, prezime, korime FROM korisnik ORDER BY prezime ASC";
					 }
					
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

							$link="<td><a class='link' href='korisnik.php?korisnik=$id&obrisi=1'>OBRIŠI</a></td>";
							if($_SESSION['aktivni_korisnik_tip'] > 0) {//samo administrator može brisati korisnika
								$link="<td><a class='link' disabled>OBRIŠI</a></td>";
							}
							
							echo $link;
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
