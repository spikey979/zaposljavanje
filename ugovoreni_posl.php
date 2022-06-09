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
		<title>Zaposljavanje majstora</title>
		<meta charset="utf-8" />
		<meta name="autor" content="Ana Dolenec" />
		<meta name="datum" content="28.05.2022." />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link href="adolenec.css" rel="stylesheet" type="text/css">
    </head>

	<body>

		<h1>Ugovoreni poslovi</h1>
			<table width = "800px" height = "50px" border="2" align="center" >
				<tr bgcolor="#1ca372">
					<td>Datum i vrijeme kreiranja</td>
					<td>Status</td>
					<td>Opis</td>
					<td>Napomena</td>
					<td>Datum i vrijeme završetka</td>
					<td></td>
				</tr>
				<?php
					$korisnik_id = $_SESSION["aktivni_korisnik_id"];
					$sql="SELECT posao_id, majstor_id, opis, datum_vrijeme_kreiranja, `status`, napomena, datum_vrijeme_završetka FROM posao WHERE korisnik_trazi_id = $korisnik_id ORDER BY datum_vrijeme_kreiranja DESC";
					$rs=izvrsiUpit($veza, $sql);
					if(mysqli_num_rows($rs)==0)$greska="Nema rezultata za postavljeni upit!";
					else{
						while(list($posao_id, $majstor_id, $opis, $datum_vrijeme_kreiranja, $status, $napomena, $datum_vrijeme_završetka)=mysqli_fetch_array($rs)) {
							switch ($status) {
								case 0:
									$status_ime = "zatražen";
								break;
								case 1:
									$status_ime = "odobren";
								break;
								case 2:
									$status_ime = "završen";
								break;
								case 3:
									$status_ime = "odbijen";
								break;
								default:
									$status_ime = "nepoznat";
							}

							$datum = strtotime($datum_vrijeme_kreiranja);
							$formatiran_dv_kreiranja = date('d.m.Y H:i:s', $datum);

							$formatiran_dv_završetka="";
							if($datum_vrijeme_završetka!=""){
								$datum = strtotime($datum_vrijeme_završetka);
								$formatiran_dv_završetka = date('d.m.Y H:i:s', $datum);
							}
							
						echo "<tr>
							<td>$formatiran_dv_kreiranja</td>
							<td>$status_ime</td>
							<td>$opis</td>
							<td>$napomena</td>
							<td>$formatiran_dv_završetka</td>
							<td><a class='link' href='ugovoreni_posl_detalji.php?posao=$posao_id'>DETALJI</a></td>
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