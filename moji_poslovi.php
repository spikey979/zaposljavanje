<?php
	include("predlosci/zaglavlje.php");

	if(session_id()=="")session_start();

	if($_SESSION['aktivni_korisnik_tip'] == NULL) {
		echo "<script> location.href='obavijest.php?poruka=Niste prijavljeni kao korisnik!'; </script>";
		exit();
	} else if($_SESSION['aktivni_korisnik_tip'] > 0) {
		echo "<script> location.href='obavijest.php?poruka=Nemate potrebne ovlasti za traženi pregled!'; </script>";
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
		
		<link href="adolenec.css" rel="stylesheet" type="text/css">
    </head>

	<body>

		<p>Moji poslovi</p>

	</body>
</html>

<?php
     include("predlosci/podnozje.php");
?>