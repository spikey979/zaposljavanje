<?php
	include("zaglavlje.php");
	include_once("baza.php");
	$veza=spojiSeNaBazu();


	if(isset($_POST["submit"])){
		$greska = "";
		$poruka = "";
		$korime = $_POST["korime"];
		if(isset($korime) && !empty($korime)
			&& isset($_POST["lozinka"]) && !empty($_POST["lozinka"])){
				/* kreiranje sql upita */
				$upit = "SELECT * FROM korisnik 
					WHERE korime='{$korime}' 
					AND lozinka = '{$_POST["lozinka"]}'";
				/* izvršavanje sql upita */
				$rezultat = izvrsiUpit($veza,$upit);
				$prijava = false;
				/* obrada rezultata sql upita */
				while($red = mysqli_fetch_array($rezultat)){
					$prijava = true;
				}
				//npr.
				//korisničko ime:admin
				//lozinka:foi
				if($prijava) {
					$poruka = "Korisnik ulogiran";
					setcookie("moj_kolacic", $poruka);
					header("Location: index.php");
					exit();
				}
				else {
					$greska = "Korisničko ime i/ili lozinka se ne podudaraju!";
				}
		}
		else{
			$greska = "Korisničko ime i/ili lozinka nisu uneseni!";
		}
	}
	/* zatvaranje veze prema bazi */
	zatvoriVezuNaBazu($veza);
?>
<form id="prijava" name="prijava" method="POST" action="prijava.php" onsubmit="return validacija();">
	<table>
		<caption>Prijava u sustav</caption>
		<tbody>
			<tr>
					<td colspan="2" style="text-align:center;">
						<!--<label class="greska"><?php if($greska!="")echo $greska; ?></label>-->
					</td>
			</tr>
			<tr>
				<td class="lijevi">
					<label for="korime"><strong>Korisničko ime:</strong></label>
				</td>
				<td>
					<input name="korime" id="korime" type="text" size="120"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="lozinka"><strong>Lozinka:</strong></label>
				</td>
				<td>
					<input name="lozinka"	id="lozinka" type="password" size="120"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input name="submit" type="submit" value="Prijavi se"/>
				</td>
			</tr>
		</tbody>
	</table>
</form>
<?php
   include_once("podnozje.php");
?>
