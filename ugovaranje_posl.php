<?php
	include("predlosci/zaglavlje.php");
	include_once("baza.php");
	include("helpers.php");

	if(session_id()=="")session_start();

	if(!isset($_SESSION['aktivni_korisnik_tip']) || $_SESSION['aktivni_korisnik_tip'] == NULL) {
		echo "<script> location.href='obavijest.php?poruka=Niste prijavljeni kao korisnik!'; </script>";
		exit();
	}
	$veza=spojiSeNaBazu();

	if(isset($_POST['submit'])){
        $korisnik_id=$_SESSION["aktivni_korisnik_id"];
        $majstor_id=$_POST['majstor'];
        $opis=$_POST['opis'];
		$datum_vrijeme_kreiranja='dtm kreiranja';
        $status=0;
        $napomena=$_POST['napomena'];
        $datum_vrijeme_završetka='dtm završetka';
        

        $sql="INSERT INTO posao 
            (korisnik_trazi_id, majstor_id, opis, datum_vrijeme_kreiranja, `status`, napomena, datum_vrijeme_završetka)
            VALUES
			($korisnik_id, $majstor_id, '$opis', NULL, $status, '$napomena', NULL);
            ";
        izvrsiUpit($veza,$sql);
        echo "<script> location.href='ugovoreni_posl.php?korisnik=$korisnik_id'; </script>";
		exit();
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
		<h1>Ugovaranje poslova</h1>
        <form method="POST" action="ugovaranje_posl.php">
        <table>
		<tbody>
			<tr>
				<td><label for="majstor"><strong>Odaberite majstora:</strong></label></td>
				<td>
					<select id="majstor" name="majstor">
                    <?php
						$sql="SELECT k.korisnik_id, k.zanimanje_id, k.ime, k.prezime, z.naziv
						FROM korisnik AS k
						JOIN zanimanje AS z ON z.zanimanje_id = k.zanimanje_id
						ORDER BY z.naziv, k.prezime ASC";
						$rs=izvrsiUpit($veza, $sql);
						if(mysqli_num_rows($rs)==0)$greska="Nema rezultata za postavljeni upit!";
                        else{
                            while(list($majstor_id, $zanimanje_id, $majstor_ime, $majstor_prezime, $zanimanje_naziv)=mysqli_fetch_array($rs)) {
								echo '<option value='.$majstor_id;
                                echo'>'.$zanimanje_naziv.', '.$majstor_prezime.' '.$majstor_ime.'</option>';
                            }
                        }

                    ?>
					</select>
				</td>
			</tr>
            <tr>
				<td>
					<label for="opis"><strong>Opis posla:</strong></label>
				</td>
				<td>
					<textarea id="opis" name="opis" rows="4" cols="50"></textarea>
				</td>
			</tr>
            <tr>
				<td>
					<label for="napomena"><strong>Napomena:</strong></label>
				</td>
				<td>
					<textarea id="napomena" name="napomena" rows="4" cols="50" ></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
				<input type="submit" name="submit" value="Ugovori posao"/>
                </td>
            </tr>
			</tbody>
	</table>
    </form>

	</body>
</html>

<?php
     include("predlosci/podnozje.php");
?>