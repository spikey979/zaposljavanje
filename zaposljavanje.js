function validacija(){
	var greska="";
  var forma=trenutnaForma();
	switch(forma){
		case "prijava":
			var kor_ime=document.getElementById("korime").value;
			var lozinka=document.getElementById("lozinka").value;
			var g=document.getElementsByClassName("greska");
			if(kor_ime==""||lozinka==""){
				greska="Molim unesite korisničko ime i lozinku<br/>";
				g[0].innerHTML=greska;
			}
			if(greska.length!=0)return false;
			break;
		default:
			break;
	}
}

function postaviDatum(text){
  var vrijeme=new Date();
  var mjesec=vrijeme.getMonth()+1;
  var dan=vrijeme.getDate();
  var godina=vrijeme.getFullYear();
  text.value=dan+"."+mjesec+"."+godina+".";
}

function postaviDatumVrijeme(text){
	var vrijeme=new Date();
	var mjesec=vrijeme.getMonth()+1;
	var dan=vrijeme.getDate();
	var godina=vrijeme.getFullYear();
	var sat=vrijeme.getHours();
	var minute=vrijeme.getMinutes();
	var sekunde=vrijeme.getSeconds();
	text.value=dan+"."+mjesec+"."+godina+". "+sat+":"+minute+":"+sekunde;
  }
