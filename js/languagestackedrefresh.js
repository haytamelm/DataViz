
function refreshStacked(){
	document.getElementById("stackederrors").innerHTML = '';
	var dated = document.getElementById('stackeddateDeb').value;
	if(dated==''){
	  document.getElementById("stackederrors").innerHTML = "date debut est vide";
	  return 0;}
	var datef = document.getElementById('stackeddateFin').value;
	if(datef==''){
	  document.getElementById("stackederrors").innerHTML = "date fin est vide";
	  return 0;}
	if(datef < dated){
	  document.getElementById("stackederrors").innerHTML = "date fin doit étre supérieure à date debut";
	  return 0;}
	nbChoixCoches = 0;
    
	var qfor=0, qag=0, qnone=0, 
       qde=0, qsp=0, qpo=0, qneg=0, qneu=0;
    
    if (document.getElementById('stackedfor').checked) { qfor=1; }
    if (document.getElementById('stackedagainst').checked) { qag=1; }
    if (document.getElementById('stackednone').checked) { qnone=1; }
    if (document.getElementById('stackedpositive').checked) { qpo=1; }
    if (document.getElementById('stackednegative').checked) { qneg=1; }
    if (document.getElementById('stackedneutral').checked) { qneu=1; }

	sendStackedData(dated,datef,qfor,qag,qnone,qpo,qneg,qneu);
}

function sendStackedData(dated,datef,qfor,qag,qnone,qpo,qneg,qneu){

xmlhttp3 = new XMLHttpRequest();
xmlhttp3.onreadystatechange = function() {
     if (xmlhttp3.readyState == 4 && xmlhttp3.status == 200) {
         console.log(xmlhttp3 .responseText);
         loadStackedChart("txt_files/datalanguagestacked.txt");
     }
};
xmlhttp3.open("POST","getData/getLanguageStackedData.php",true);
xmlhttp3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp3.send(
"&dd=" + dated + "&df=" + datef 
+ "&for=" + qfor + "&ag=" + qag + "&none=" + qnone
+ "&po=" + qpo + "&neg=" + qneg + "&neu=" + qneu
);
}