<?php
	include_once("baza.php");
	include "helpers.php";

	session_start();

	$veza=spojiSeNaBazu();

	if(isset($_GET['logout'])){
		unset($_SESSION["aktivni_korisnik"]);
		unset($_SESSION['aktivni_korisnik_ime']);
		unset($_SESSION["aktivni_korisnik_tip"]);
		unset($_SESSION["aktivni_korisnik_id"]);
		session_destroy();
		header("Location:index.php");
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
				header("Location:index.php");
			}
		}
		else $greska = "Molim unesite korisničko ime i lozinku";
	}
	
	zatvoriVezuNaBazu($veza);
?>
 <head>
 	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<div id="zaglavlje"></div>
<script>
	$(function(){ $("#zaglavlje").load("/predlosci/zaglavlje.php"); });
</script>

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

<div id="podnozje"></div>
<script>
	$(function() { $("#podnozje").load("/predlosci/podnozje.html"); });
</script>