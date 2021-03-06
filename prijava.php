<?php
 	include("predlosci/zaglavlje.php");
	include_once("baza.php");

	if(session_id()=="")session_start();

	$veza=spojiSeNaBazu();

	if(isset($_GET['logout'])){
		unset($_SESSION["aktivni_korisnik"]);
		unset($_SESSION['aktivni_korisnik_ime']);
		unset($_SESSION["aktivni_korisnik_tip"]);
		unset($_SESSION["aktivni_korisnik_id"]);
		unset($_SESSION['aktivni_korisnik_tip_naziv']);
		session_destroy();

		echo "<script> location.href='index.php'; </script>";
		exit();
	}

	$greska= "";
	if(isset($_POST['submit'])){
		$kor_ime=mysqli_real_escape_string($veza,$_POST['korisnicko_ime']);
		$lozinka=mysqli_real_escape_string($veza,$_POST['lozinka']);

		if(!empty($kor_ime)&&!empty($lozinka)){
			$sql="SELECT korisnik_id, tip_korisnika_id, ime, prezime FROM korisnik WHERE korime='$kor_ime' AND lozinka='$lozinka'";
			$rs=izvrsiUpit($veza, $sql);
			if(mysqli_num_rows($rs)==0)$greska="Ne postoji korisnik s upisanim podacima!";
			else{
				list($id,$tip,$ime,$prezime)=mysqli_fetch_array($rs);
				$_SESSION['aktivni_korisnik']=$kor_ime;
				$_SESSION['aktivni_korisnik_ime']=$ime." ".$prezime;
				$_SESSION["aktivni_korisnik_id"]=$id;
				$_SESSION['aktivni_korisnik_tip']=$tip;

				$sql="SELECT naziv FROM tip_korisnika WHERE tip_korisnika_id=$tip";
				$rs1=izvrsiUpit($veza,$sql);
				if(mysqli_num_rows($rs1)==0)$greska="Nepoznati tip korisnika!";
				else{
					list($tip_korisnika_naziv)=mysqli_fetch_array($rs1);
					$_SESSION['aktivni_korisnik_tip_naziv']=$tip_korisnika_naziv;
				}

				echo "<script> location.href='index.php'; </script>";
				exit();
			}
		}
		else $greska = "Molim unesite korisničko ime i lozinku";
	}
	
	zatvoriVezuNaBazu($veza);
?>
<!DOCTYPE html>
<html>

	<head>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	</head>

	<form id="prijava" name="prijava" method="POST" action="prijava.php" onsubmit="return validacija();">
		<table>
			<caption>Prijava u sustav</caption>
			<tbody>
				<tr>
					<td colspan="2" style="text-align:center;">
						<label class="greska"><?php if($greska!="")echo $greska; ?></label>
					</td>
				</tr>
				<tr>
					<td class="lijevi">
						<label for="korisnicko_ime"><strong>Korisničko ime:</strong></label>
					</td>
					<td>
						<input name="korisnicko_ime" id="korisnicko_ime" type="text" size="110"/>
					</td>
				</tr>
				<tr>
					<td>
						<label for="lozinka"><strong>Lozinka:</strong></label>
					</td>
					<td>
						<input name="lozinka"	id="lozinka" type="password" size="110"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;">
						<input name="submit" type="submit" value="Prijavi se"/>
					</td>
				</tr>
			</tbody>
		</table>
	</form>

</html>

<?php
     include("predlosci/podnozje.php");
?>