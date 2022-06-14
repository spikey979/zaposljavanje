<?php
     include("predlosci/zaglavlje.php");
	 include_once("baza.php");
	 include("helpers.php");

	if(session_id()=="")session_start();

	if($_SESSION['aktivni_korisnik_tip'] == NULL) {
		echo "<script> location.href='obavijest.php?poruka=Niste prijavljeni kao korisnik!'; </script>";
		exit();
	} else if($_SESSION['aktivni_korisnik_tip'] > 1) {//samo majstori i admin
		echo "<script> location.href='obavijest.php?poruka=Nemate potrebne ovlasti za traženi pregled!'; </script>";
		exit();
	}

	$veza=spojiSeNaBazu();

    if(isset($_POST['submit'])){
        $posao_id=$_SESSION['posao_id'];
        unset($_SESSION["posao_id"]);

        $datum_vrijeme_kreiranja=$_SESSION["dv_kreiranja"];
        unset($_SESSION["dv_kreiranja"]);
        
        $status_posla=$_POST['status'];
        $datum_vrijeme_zavrsetka=NULL;
 
        if($status_posla==2) {
            $datum_vrijeme_zavrsetka=date('Y-m-d H:i:s');
            $sql="UPDATE posao SET 
            `status`=$status_posla,
            datum_vrijeme_kreiranja='$datum_vrijeme_kreiranja',
            datum_vrijeme_završetka='$datum_vrijeme_zavrsetka'
            WHERE posao_id=$posao_id
            ";
        } else {
            $sql="UPDATE posao SET 
            `status`=$status_posla,
            datum_vrijeme_kreiranja='$datum_vrijeme_kreiranja',
            datum_vrijeme_završetka=NULL
            WHERE posao_id=$posao_id
            ";
        }
        izvrsiUpit($veza,$sql);       
        echo "<script> location.href='moji_poslovi_detalji.php?posao=$posao_id'; </script>";
        exit();
	}

    if(isset($_POST['dodaj_sliku'])){
        $slika_url=$_POST['slika_url'];
        $posao_id=$_SESSION['posao_id'];
        unset($_SESSION["posao_id"]);
        $majstor_id=$_SESSION["aktivni_korisnik_id"];
        $vrijeme_postavljanja=date("Y-m-d H:i:s");
       
        $sql="INSERT INTO slika 
            (posao_id, slika, datum_vrijeme_postavljanja)
            VALUES
			($posao_id, '$slika_url', '$vrijeme_postavljanja');
            ";
        izvrsiUpit($veza,$sql);
        echo "<script> location.href='moji_poslovi_detalji.php?posao=$posao_id'; </script>";
		exit();
	}

    if(isset($_GET['posao'])){
        //dohvati posao po posao_id ključu
		$posao_id=$_GET['posao'];
        $_SESSION["posao_id"]=$posao_id;
		$sql="SELECT opis, datum_vrijeme_kreiranja, `status`, napomena, datum_vrijeme_završetka FROM posao WHERE posao_id=$posao_id";
		$rs=izvrsiUpit($veza,$sql);
		list($opis, $datum_vrijeme_kreiranja, $status, $napomena, $datum_vrijeme_završetka)=mysqli_fetch_array($rs);

        $_SESSION["dv_kreiranja"]=$datum_vrijeme_kreiranja;


        //formatiranje datuma
        $datum = strtotime($datum_vrijeme_kreiranja);
        $formatiran_dv_kreiranja = date('d.m.Y H:i:s', $datum);

        $formatiran_dv_završetka="";
        if($datum_vrijeme_završetka!=""){
            $datum = strtotime($datum_vrijeme_završetka);
            $formatiran_dv_završetka = date('d.m.Y H:i:s', $datum);
        }

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
		
		<h1>Moj posao - detalji</h1>
        <form method="POST" action="moji_poslovi_detalji.php">
        <table>
		<tbody>
			<tr>
				<td>
					<label for="dv_kreiranja"><strong>Datum i vrijeme kreiranja:</strong></label>
				</td>
				<td>
					<input type="text" name="dv_kreiranja" value="<?php echo $formatiran_dv_kreiranja; ?>" size="51" maxlength="50" disabled/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="status"><strong>Status:</strong></label>
				</td>
				<td>
                    <select id="status" name="status">
                    <?php
                        $statusi = array("zatražen", "odobren", "završen", "odbijen");
                        for ($i = 0; $i < 4; $i++) {
                            echo "<option value=".$i;
                            if($status == $i) {
                                echo " selected='selected'";
                            }
                            echo ">".$statusi[$i].'</option>';
                        } 
                    
                    ?>

				</td>
			</tr>
            <tr>
				<td>
					<label for="opis"><strong>Opis posla:</strong></label>
				</td>
				<td>
				    <textarea id="opis" name="opis" rows="4" cols="50" disabled><?php echo $opis; ?></textarea>
				</td>
			</tr>
            <tr>
				<td>
					<label for="napomena"><strong>Napomena:</strong></label>
				</td>
				<td>
				    <textarea id="napomena" name="napomena" rows="4" cols="50" disabled><?php echo $napomena; ?></textarea>
				</td>
			</tr>
           
            <tr>
				<td>
					<label for="dv_zavrsetka"><strong>Datum i vrijeme završetka:</strong></label>
				</td>
				<td>
					<!-- <input type="text" name="dv_zavrsetka" value="<?php echo $formatiran_dv_završetka; ?>" placeholder="dd.mm.gggg. hh:mm:ss" size="51" maxlength="50" onclick="postaviDatumVrijeme(this)"/> -->
                    <input type="text" name="dv_zavrsetka" value="<?php echo $formatiran_dv_završetka; ?>" size="51" maxlength="50" disabled/>
				</td>
			</tr>
            <tr>
				<td colspan="2" style="text-align:right;">
				<input type="submit" name="submit" value="Spremi promjene"/>
                </td>
            </tr>
            <tr>
				<td>
                    <input type="submit" name="dodaj_sliku" value="Dodaj sliku"/>
				</td>
				<td>
					<input type="text" name="slika_url" placeholder="zalijepi link do slike" size="51" maxlength="500"/>
				</td>
			</tr>

            </tbody>
	    </table>

        <table style="border-spacing:0; margin-left: auto; margin-right: auto; text-alignt:" center>
			
            <?php
                $sql="SELECT DISTINCT slika FROM slika WHERE posao_id=$posao_id ORDER BY datum_vrijeme_postavljanja DESC";
                $rs=izvrsiUpit($veza, $sql);
                if (isset($rs)){
                    if(mysqli_num_rows($rs)>0)echo "<h1>Slike</h1>";
                    while($rows = mysqli_fetch_array($rs)) {
                        
                        if(!isset($SESSION["tip"])){
                            echo"<tr>";
                            echo'<td><img src=' . $rows["slika"] .' height="400" width="600" ></td>';
                            echo"</tr>";
                        }
                        if(!isset($SESSION["tip"])){
                            echo"<tr>";
                            echo"<td></td>";
                            echo"</tr>";
                        }
                    }
                }
            ?>

		</table>
        </form>

    </body>

</html>

<?php
     include("predlosci/podnozje.php");
?>