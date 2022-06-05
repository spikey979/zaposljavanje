<?php
	include "helpers.php";

	if(session_id()=="")session_start();

	if($_SESSION['aktivni_korisnik_tip'] == NULL) {
		header("Location:obavijest.php?poruka=Niste prijavljeni kao korisnik!");
	} else if($_SESSION['aktivni_korisnik_tip'] > 0) {
		header("Location:obavijest.php?poruka=Nemate potrebne ovlasti za traženi pregled!");
	}

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
		<div id="zaglavlje"></div>
		<script>
			$(function() { $("#zaglavlje").load("/predlosci/zaglavlje.php"); });
		</script>

		<p>Ugovoreni poslovi</p>

		<div id="podnozje"></div>
		<script>
			$(function() { $("#podnozje").load("/predlosci/podnozje.html"); });
		</script>
	</body>
</html>
