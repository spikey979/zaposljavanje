/* function trenutnaForma(){
	var trenutnaForma=document.getElementsByTagName("form")[0]["name"];
	if(typeof(trenutnaForma)=='undefined')return null;
	return trenutnaForma;
} */

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
  var currentTime=new Date();
  var month=currentTime.getMonth()+1;
  var day=currentTime.getDate();
  var year=currentTime.getFullYear();
  text.value=day+"."+month+"."+year+".";
}

/* function sakrijMeni(){
  var meni=document.getElementById("navigacija");
  var tekst=document.getElementById("tekst");
  if(meni.style.visibility==="hidden"){
    meni.style.visibility="visible";
		meni.style.display="block";
    tekst.innerHTML="sakrij meni";
	}
	else{
		meni.style.visibility="hidden";
		meni.style.display="none";
		tekst.innerHTML="prikaži meni";
	}
} */

/* function poruka() {
    console.log("ovo je greška");
} */

/* $(document).ready(function(){
	
	$('#btnIzdvojiDarivatelje').click(function () {
		//console.log("ovo je btnIzdvojiDarivatelje");
		modalStatusiObavijest(strTitle="Obavijest", 'Budite strpljivi, podaci se učitavaju...')
		AjGetTblDarivateljiPoKriterijima();
	});

    $("#chkbxSveAkcije").change(function() {
		if(this.checked) {
			AjTraziAktivnuAkciju(sveAkcije="true")
		} else {
			//$('#tblDarivatelji').DataTable().clear().draw();
			AjTraziAktivnuAkciju(sveAkcije="false")
		}

	});



}); */

