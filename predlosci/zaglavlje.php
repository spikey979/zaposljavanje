<?php
//include("baza.php");
	include "../helpers.php";
	
	if(session_id()=="")session_start();

	//$trenutna=basename($_SERVER["PHP_SELF"]);
	//$putanja=$_SERVER['REQUEST_URI'];
	//$aktivni_korisnik = 0;
	//$aktivni_korisnik_tip=-1;
	//$vel_str=5; // broj prikazanih elemenata na stranici s korisnicima
	//$vel_str_video=20; 	// broj prikazanih elemenata na stranici s video materijalima

	if(isset($_SESSION['aktivni_korisnik'])){
		$aktivni_korisnik=$_SESSION['aktivni_korisnik'];
		$aktivni_korisnik_ime=$_SESSION['aktivni_korisnik_ime'];
		$aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
		$aktivni_korisnik_id=$_SESSION["aktivni_korisnik_id"];
	}
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
		<script type="text/javascript" src="zaposljavanje.js"></script>

		<style>
			h1 { text-align:center; }
		</style>

	</head>

	<body>
		<h1>Sustav za zapošljavanje majstora</h1>

		<div class="header">
			<?php			
				if($_SESSION['aktivni_korisnik'] != NULL){
					echo "<span><strong>Korisnik: </strong>$aktivni_korisnik_ime</span><br/>";
					echo "<a class='link' href='prijava.php?logout=1'>Odjava</a><br/>";
				}
				else{
					echo "<span><strong>Korisnik: </strong>Neprijavljeni korisnik</span><br/>";
					echo "<a class='link' href='prijava.php'>Prijava</a><br/>";
				}

				echo "<br/><a class='link' href='o_autoru.html'>O autoru</a>";
			?>
		</div>

		<div class="nav">
			<!-- <a class="active" href="index.php">Početna</a> -->
			<a href="index.php">Početna</a>
			<a href="galerija.php">Galerija</a>
			<a href="ugovaranje_posl.php">Ugovaranje poslova</a>
			<a href="ugovoreni_posl.php">Ugovoreni poslovi</a>
			<a href="moji_poslovi.php">Moji poslovi</a>
			<a href="zanimanja.php">Zanimanja</a>
			<a href="korisnici.php">Korisnici</a>
		</div>

	</body>
</html>
