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

    if(isset($_POST['submit'])){
        
        $id=$_POST['id'];
        $korime=$_POST['korime'];
        $prezime=$_POST['prezime'];
        $telefon=$_POST['telefon'];
        $email=$_POST['email'];
        $lozinka=$_POST['lozinka'];
        $ime=$_POST['ime'];
        $tip_korisnika = $_POST["tip"];
        $korisnik_zanimanje_id = $_POST["zanimanje"];
        if($korisnik_zanimanje_id == 0) {
            $korisnik_zanimanje_id = 'NULL';
        }

        if($id==0){
            $sql="INSERT INTO korisnikx
            (id_tip,korisnicko_ime,lozinka,ime,prezime,email,slika)
            VALUES
            ($tip,'$kor_ime','$lozinka','$ime','$prezime','$email','$slika');
            ";
        }
        else{
            $sql="UPDATE korisnik SET 
                tip_korisnika_id=$tip_korisnika,
                zanimanje_id=$korisnik_zanimanje_id,
                korime='$korime',
                email='$email',
                ime='$ime',
                prezime='$prezime', 
                lozinka='$lozinka',
                telefonski_broj='$telefon'
                WHERE korisnik_id=$id
                ";
        }
        izvrsiUpit($veza,$sql);
        echo "<script> location.href='korisnici.php'; </script>";
        exit();
	}

    if(isset($_GET['korisnik'])){
        $uredi = 'disabled';
        if(isset($_GET['uredi'])){
            $uredi = 'enabled';
        }
		$id=$_GET['korisnik'];
		$sql="SELECT tip_korisnika_id, zanimanje_id, korime, prezime, ime, zanimanje_id, email, telefonski_broj, lozinka FROM korisnik WHERE korisnik_id='$id'";
		$rs=izvrsiUpit($veza,$sql);
		list($tip_korisnika, $korisnik_zanimanje_id, $korime, $prezime, $ime, $zanimanje_id, $email, $telefon, $lozinka)=mysqli_fetch_array($rs);
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
		
		<h1>Korisnik - detalji</h1>
        <form method="POST" action="korisnik.php">
        <table>
		<tbody>
            <tr>
				<td>
					<label for="id"><strong>ID:</strong></label>
				</td>
				<td>
					<input type="text" name="id" id="id" value="<?php echo $id; ?>" size="50" maxlength="50" readonly/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="korime"><strong>Korisničko ime:</strong></label>
				</td>
				<td>
					<input type="text" name="korime" id="korime" value="<?php echo $korime; ?>" size="50" maxlength="50" <?php echo $uredi; ?> required/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="prezime"><strong>Prezime:</strong></label>
				</td>
				<td>
					<input type="text" name="prezime" id="prezime" value="<?php echo $prezime; ?>" size="50" maxlength="50" <?php echo $uredi; ?> required/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="ime"><strong>Ime:</strong></label>
				</td>
				<td>
					<input type="text" name="ime" id="ime" value="<?php echo $ime; ?>" size="50" maxlength="50" <?php echo $uredi; ?> required/>
				</td>
			</tr>
           
            <tr>
				<td>
					<label for="telefon"><strong>Telefon:</strong></label>
				</td>
				<td>
					<input type="text" name="telefon" id="telefon" value="<?php echo $telefon; ?>" size="50" maxlength="50" <?php echo $uredi; ?>/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="email"><strong>E-mail:</strong></label>
				</td>
				<td>
					<input type="text" name="email" id="email" value="<?php echo $email; ?>" size="50" maxlength="50" <?php echo $uredi; ?>/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="lozinka"><strong>Lozinka:</strong></label>
				</td>
				<td>
					<input type="text" name="lozinka" id="lozinka" value="<?php echo $lozinka; ?>" size="50" maxlength="50" <?php echo $uredi; ?> required/>
				</td>
			</tr>
            <tr>
				<td><label for="tip"><strong>Tip korisnika:</strong></label></td>
				<td>
					<select id="tip" name="tip" <?php echo $uredi; ?>>
						<?php
                        	echo '<option value="0"';if($tip_korisnika==0)echo " selected='selected'";echo'>Administrator</option>';
							echo '<option value="1"';if($tip_korisnika==1)echo " selected='selected'";echo'>Zaposlenik</option>';
							echo '<option value="2"';if($tip_korisnika==2)echo " selected='selected'";echo'>Korisnik</option>';
						?>
					</select>
				</td>
			</tr>
            <tr>
				<td><label for="tip"><strong>Zanimanje:</strong></label></td>
				<td>
					<select id="zanimanje" name="zanimanje" <?php echo $uredi; ?>>
                    <?php
                        $sql="SELECT zanimanje_id, naziv FROM zanimanje ORDER BY naziv ASC";
                        $rs=izvrsiUpit($veza, $sql);
                        if(mysqli_num_rows($rs)==0)$greska="Nema rezultata za postavljeni upit!";
                        else{
                            echo '<option value=0 selected="selected">nepoznato</option>';
                            while(list($zanimanje_id, $zanimanje_naziv)=mysqli_fetch_array($rs)) {
                                echo '<option value='.$zanimanje_id;
                                if($korisnik_zanimanje_id == $zanimanje_id) {
                                    echo " selected='selected'";
                                }
                                echo'>'.$zanimanje_naziv.'</option>';
                            }
                        }
                    ?>
					</select>
				</td>
			</tr>
            <tr>
				<td colspan="2" style="text-align:center;">
                    <input type="submit" name="submit" value="Spremi"/>
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
