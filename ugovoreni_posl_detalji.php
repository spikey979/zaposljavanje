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

    if(isset($_GET['posao'])){
        //dohvati posao po posao_id ključu
		$posao_id=$_GET['posao'];
		$sql="SELECT majstor_id, opis, datum_vrijeme_kreiranja, `status`, napomena, datum_vrijeme_završetka FROM posao WHERE posao_id=$posao_id";
		$rs=izvrsiUpit($veza,$sql);
		list($majstor_id, $opis, $datum_vrijeme_kreiranja, $status, $napomena, $datum_vrijeme_završetka)=mysqli_fetch_array($rs);

        //dohvati majstora po majstor_id ključu
        $sql="SELECT ime, prezime, zanimanje_id FROM korisnik WHERE korisnik_id = $majstor_id";
        $rs=izvrsiUpit($veza,$sql);
        list($majstor_ime, $majstor_prezime, $zanimanje_id)=mysqli_fetch_array($rs);

        //dohvati naziv zanimanja po zanimanje_id ključu
        $sql="SELECT naziv FROM zanimanje WHERE zanimanje_id =$zanimanje_id";
        $rs=izvrsiUpit($veza, $sql);
        list($zanimanje_naziv)=mysqli_fetch_array($rs);

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
		
		<h1>Ugovoreni posao - detalji</h1>
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
					<input type="text" name="status" value="<?php echo $status_ime; ?>" size="51" maxlength="50" disabled/>
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
					<label for="ime_majstora"><strong>Ime i prezime majstora:</strong></label>
				</td>
				<td>
					<input type="text" name="ime_majstora" value="<?php echo $majstor_ime.' '.$majstor_prezime; ?>" size="51" maxlength="50" disabled/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="zanimanje_majstora"><strong>Zanimanje majstora:</strong></label>
				</td>
				<td>
					<input type="text" name="zanimanje_majstora" value="<?php echo $zanimanje_naziv; ?>" size="51" maxlength="50" disabled/>
				</td>
			</tr>
            <tr>
				<td>
					<label for="dv_zavrsetka"><strong>Datum i vrijeme završetka:</strong></label>
				</td>
				<td>
					<input type="text" name="dv_zavrsetka" value="<?php echo $formatiran_dv_završetka; ?>" size="51" maxlength="50" disabled/>
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

    </body>

</html>

<?php
     include("predlosci/podnozje.php");
?>