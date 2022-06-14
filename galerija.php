<?php
    include("predlosci/zaglavlje.php");
	include_once("baza.php");
	include("helpers.php");
	
	if(session_id()=="")session_start();


	$veza=spojiSeNaBazu();

	$filter_datum="";
	$filter_zanimanje_id = 'NULL';
	if(isset($_POST['submit'])){
		$filter_zanimanje_id = $_POST["zanimanje"];
        if($filter_zanimanje_id == 0) {
            $filter_zanimanje_id = 'NULL';
        }

		if(isset($_POST['od'])&&strlen($_POST['od']>0)){
			$od = strtotime($_POST['od']);
			$od=date('Y-m-d H:i:s',$od );
			$filter_datum=" AND datum_vrijeme_postavljanja > '$od'";
		  }
		if(isset($_POST['do'])&&strlen($_POST['do']>0)){
			$do=strtotime($_POST['do']);
			$do=date('Y-m-d H:i:s',$do);
			$filter_datum=$filter_datum." AND datum_vrijeme_postavljanja IS NOT NULL AND datum_vrijeme_postavljanja < '$do'";
		}
	}

	if(isset($_POST['reset'])){
		unset($_POST["zanimanje"]);
		unset($_POST["od"]);
		unset($_POST["do"]);
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
	
	<h1>Galerija slika</h1>

	<?php


	//prikazuj samo ako je korisnik logiran
	if(isset($_SESSION['aktivni_korisnik_tip']) && $_SESSION['aktivni_korisnik_tip'] != NULL) {
			echo '<form method="POST" action="galerija.php"> <table> <caption><strong>FILTER</strong></caption> <tbody>';
			echo '<tr>';

			echo '<td><label for="od">Datum od:</label>';
			echo '<input type="text" placeholder="dd.mm.gggg." value="';if(isset($_POST['od'])&&!isset($_GET['reset']))echo $_POST['od'];
			echo '" name="od" id="od" size="10" onclick="postaviDatum(this)"/></td>
			<td><label for="do">Datum do:</label>';
			echo '<input type="text" placeholder="dd.mm.gggg." value="';if(isset($_POST['do'])&&!isset($_GET['reset']))echo $_POST['do'];
			echo '" name="do" id="do" size="10" onclick="postaviDatum(this)"/></td>';

			echo '<td><label for="tip">Zanimanje:</label></td>';
			echo '<td> <select id="zanimanje" name="zanimanje">';
				$sql="SELECT zanimanje_id, naziv FROM zanimanje ORDER BY naziv ASC";
				$rs=izvrsiUpit($veza, $sql);
				if(mysqli_num_rows($rs)==0)$greska="Nema rezultata za postavljeni upit!";
				else{
					echo '<option value=0 selected="selected">svi</option>';
					while(list($zanimanje_id, $zanimanje_naziv)=mysqli_fetch_array($rs)) {
						echo '<option value='.$zanimanje_id;
						if(isset($_POST['zanimanje']) && $filter_zanimanje_id == $zanimanje_id) {
							echo " selected='selected'";
						}
						echo'>'.$zanimanje_naziv.'</option>';
					}
				}
			echo '</select> </td>';
			echo '<td><input type="submit" name="submit" value="Filtriraj"/></td>';
			echo '<td><input type="submit" name="reset" value="Poništi filter"/></td>';
			echo '</tr>';
			echo '</tbody> </table> </form>';
	}
	?>

	
	
       <table style="border-spacing:0; margin-left: auto; margin-right: auto; text-alignt: center">
			
		<?php
			$sql="SELECT DISTINCT slika, posao_id FROM slika ORDER BY datum_vrijeme_postavljanja DESC";
			if($filter_datum!='') {
				$sql="SELECT DISTINCT slika, posao_id FROM slika WHERE 1=1 $filter_datum ORDER BY datum_vrijeme_postavljanja DESC";
			}
			
			$rs=izvrsiUpit($veza, $sql);
			if (isset($rs)){			  
				while(list($slika, $posao_id)=mysqli_fetch_array($rs)) {

					$sql="SELECT `status` FROM posao WHERE posao_id=$posao_id;";
					$rs_0=izvrsiUpit($veza,$sql);
					list($status)=mysqli_fetch_array($rs_0);
					if($status != 2) {//filtriraj samo zavšene poslove - status 2
						continue;
					}

					//odredi zanimanje id
					$sql="SELECT zanimanje_id FROM korisnik 
							WHERE korisnik_id=(
								SELECT majstor_id FROM posao WHERE posao_id=$posao_id
							);
					";
					$rs_0=izvrsiUpit($veza,$sql);
					list($zanimanje_id)=mysqli_fetch_array($rs_0);

					if($filter_zanimanje_id!=NULL && $filter_zanimanje_id>0) { //ako se upotrebljava filter, izbaci sve što ne odgovara kriterijima filtera
						if($zanimanje_id != $filter_zanimanje_id) {
							continue;
						}
					}


					$sql="SELECT naziv FROM zanimanje 
						WHERE zanimanje_id=$zanimanje_id;
					";


					$rs_1=izvrsiUpit($veza,$sql);
					list($naziv_zanimanja)=mysqli_fetch_array($rs_1);

					if(!isset($SESSION["tip"])){
						echo'<tr><td style="text-align:center"><h3>'.$naziv_zanimanja.'</h3></td></tr>';
                        echo"<tr>";						
						echo'<td>';
						
						if(isset($_SESSION['aktivni_korisnik_tip']) && $_SESSION['aktivni_korisnik_tip'] != NULL) { //slika je link samo za prijavljenog korisnika... 
							echo '<a href="ugovoreni_posl_detalji.php?posao='.$posao_id.'">';
							
						}

						echo '<img src='.$slika.' height="400" width="600" >';

						if(isset($_SESSION['aktivni_korisnik_tip']) && $_SESSION['aktivni_korisnik_tip'] != NULL) {
							echo '</a>';
						}
						echo " </td>";
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
