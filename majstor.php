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

    if(isset($_GET['majstor'])){
		$id=$_GET['majstor'];
		$sql="SELECT prezime, ime, zanimanje_id, email, telefonski_broj FROM korisnik WHERE korisnik_id='$id'";
		$rs=izvrsiUpit($veza,$sql);
		list($prezime,$ime,$zanimanje_id,$email,$telefon)=mysqli_fetch_array($rs);

        $zanimanje_naziv = "nepoznato";
        $sql="SELECT naziv FROM zanimanje WHERE zanimanje_id ='$zanimanje_id'";
        $rs_1=izvrsiUpit($veza, $sql);
        if(mysqli_num_rows($rs_1)==0)$greska="Nema rezultata za postavljeni upit!";
        else {
            list($zanimanje_naziv)=mysqli_fetch_array($rs_1);
        }
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

    </head>
    
    <body>
		
		<h1>Majstor - detalji</h1>

        <table>
		<tbody>
			<tr>
				<td>
					<label for="prezime"><strong>Prezime:</strong></label>
				</td>
				<td>
					<input type="text" name="prezime" id="prezime" value="<?php echo $prezime; ?>" size="50" maxlength="50"/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="ime"><strong>Ime:</strong></label>
				</td>
				<td>
					<input type="text" name="ime" id="ime" value="<?php echo $ime; ?>" size="50" maxlength="50"/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="zanimanje"><strong>Zanimanje:</strong></label>
				</td>
				<td>
					<input type="text" name="zanimanje" id="zanimanje" value="<?php echo $zanimanje_naziv; ?>" size="50" maxlength="50"/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="telefon"><strong>Telefon:</strong></label>
				</td>
				<td>
					<input type="text" name="telefon" id="telefon" value="<?php echo $telefon; ?>" size="50" maxlength="50"/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="email"><strong>E-mail:</strong></label>
				</td>
				<td>
					<input type="text" name="email" id="email" value="<?php echo $email; ?>" size="50" maxlength="50"/>
				</td>
			</tr>
			
			
		</tbody>
	</table>
			
	
    </body>

</html>

<?php
     include("predlosci/podnozje.php");
?>
