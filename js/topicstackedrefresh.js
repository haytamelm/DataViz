
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
    
	var qen=0, qfr=0, qit=0, 
       qde=0, qsp=0, qpo=0, qneg=0, qneu=0;
    
    if (document.getElementById('stackedenglish').checked) { qen=1; }
    if (document.getElementById('stackedfrench').checked) { qfr=1; }
    if (document.getElementById('stackeditalia').checked) { qit=1; }
    if (document.getElementById('stackeddeutche').checked) { qde=1; }
    if (document.getElementById('stackedspanish').checked) { qsp=1; }
    if (document.getElementById('stackedpositive').checked) { qpo=1; }
    if (document.getElementById('stackednegative').checked) { qneg=1; }
    if (document.getElementById('stackedneutral').checked) { qneu=1; }

	sendStackedData(dated,datef,qen,qfr,qit,qde,qsp,qpo,qneg,qneu);
}

function sendStackedData(dated,datef,qen,qfr,qit,qde,qsp,qpo,qneg,qneu){

xmlhttp3 = new XMLHttpRequest();
xmlhttp3.onreadystatechange = function() {
     if (xmlhttp3.readyState == 4 && xmlhttp3.status == 200) {
         console.log(xmlhttp3.responseText);
         loadStackedChart("txt_files/datatopicstacked.txt");
     }
};
xmlhttp3.open("POST","getData/getTopicStackedData.php",true);
xmlhttp3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp3.send(
"&dd=" + dated + "&df=" + datef 
+ "&en=" + qen + "&fr=" + qfr + "&it=" + qit + "&de=" + qde + "&sp=" + qsp 
+ "&po=" + qpo + "&neg=" + qneg + "&neu=" + qneu
);
}