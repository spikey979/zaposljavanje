<?php
     include("predlosci/zaglavlje.php");
	 include_once("baza.php");

	if(session_id()=="")session_start();

	if($_SESSION['aktivni_korisnik_tip'] == NULL) {
		echo "<script> location.href='obavijest.php?poruka=Niste prijavljeni kao korisnik!'; </script>";
		exit();
	} else if($_SESSION['aktivni_korisnik_tip'] > 0) {
		echo "<script> location.href='obavijest.php?poruka=Nemate potrebne ovlasti za traženi pregled!'; </script>";
	}

	$veza=spojiSeNaBazu();

    if(isset($_POST['submit'])){
        $id=$_POST['id'];
        $naziv=$_POST['naziv'];
        $opis=$_POST['opis'];

        $sql="UPDATE zanimanje SET 
            naziv='$naziv',
            opis='$opis'
            WHERE zanimanje_id=$id
            ";
        
        izvrsiUpit($veza,$sql);
        echo "<script> location.href='zanimanja.php'; </script>";
        exit();
	}

    if(isset($_POST['dodaj'])){
        $naziv=$_POST['naziv'];
        $opis=$_POST['opis'];
       
        //provjeri postoji li već takvo zanimanje u bazi
        $sql="SELECT zanimanje_id FROM zanimanje WHERE naziv='$naziv'";
        $rs=izvrsiUpit($veza,$sql);
        list($zanimanje_id)=mysqli_fetch_array($rs);
        if(mysqli_num_rows($rs)>0) {
            echo "<script> location.href='obavijest.php?poruka=Zanimanje: ".$naziv." već postoji u bazi zanimanja!'; </script>";
            exit();
        }

        $sql="INSERT INTO zanimanje
            (naziv, opis)
            VALUES
            ('$naziv', '$opis');
            ";
        izvrsiUpit($veza,$sql);
        echo "<script> location.href='zanimanja.php'; </script>";
        exit();
    }

    if(isset($_POST['brisi'])){
        $id=$_POST['id'];
        $sql="DELETE FROM zanimanje WHERE zanimanje_id=$id";
        $rs=izvrsiUpit($veza,$sql);
        echo "<script> location.href='zanimanja.php'; </script>";
        exit();
    }

    if(isset($_GET['zanimanje'])){
        $uredi = 'disabled';
        if(isset($_GET['uredi']) || isset($_GET['dodaj'])){
            $uredi = 'enabled';
        }
        if(!isset($_GET['dodaj'])) {
            $id=$_GET['zanimanje'];
            $sql="SELECT naziv, opis FROM zanimanje WHERE zanimanje_id='$id'";
            $rs=izvrsiUpit($veza,$sql);
            list($naziv, $opis)=mysqli_fetch_array($rs);
        } else {
            //dodavanje novog zanimanja
            $id = "";
            $naziv="";
            $opis="";
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
    <h1>Zanimanja</h1>
    <form method="POST" action="zanimanje.php">
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
					<label for="naziv"><strong>Naziv:</strong></label>
				</td>
				<td>
					<input type="text" name="naziv" id="naziv" value="<?php echo $naziv; ?>" size="50" maxlength="50" <?php echo $uredi; ?> required/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="opis"><strong>Opis:</strong></label>
				</td>
				<td>
					<input type="text" name="opis" id="opis" value="<?php echo $opis; ?>" size="100" maxlength="100" <?php echo $uredi; ?> required/>
				</td>
			</tr>
            <tr>
				<td colspan="2" style="text-align:center;">
                    <?php
                        if(isset($_GET['uredi'])){
                            echo '<input type="submit" name="submit" value="Spremi promjene"/>';
                        } else if(isset($_GET['obrisi'])){
                            echo '<input type="submit" name="brisi" value="Obriši zanimanje"/>';
                        } else if(isset($_GET['dodaj'])){
                            echo '<input type="submit" name="dodaj" value="Dodaj novo zanimanje"/>';
                        }
					?>
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