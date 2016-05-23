
function refreshMsline(){
	document.getElementById("pieerrors").innerHTML = '';
	var dated = document.getElementById('mslinedateDeb').value;
	if(dated==''){
	  document.getElementById("mslineerrors").innerHTML = "date debut est vide";
	  return 0;}
	var datef = document.getElementById('mslinedateFin').value;
	if(datef==''){
	  document.getElementById("mslineerrors").innerHTML = "date fin est vide";
	  return 0;}
	if(datef < dated){
	  document.getElementById("mslineerrors").innerHTML = "date fin doit étre supérieure à date debut";
	  return 0;}
	nbChoixCoches = 0;
    
	var qen=0, qfr=0, qit=0, 
       qde=0, qsp=0, qfor=0, qag, qnone=0;
    
    if (document.getElementById('mslineenglish').checked) { qen=1; }
    if (document.getElementById('mslinefrench').checked) { qfr=1; }
    if (document.getElementById('mslineitalia').checked) { qit=1; }
    if (document.getElementById('mslinedeutche').checked) { qde=1; }
    if (document.getElementById('mslinespanish').checked) { qsp=1; }
    if (document.getElementById('mslinefor').checked) { qfor=1; }
    if (document.getElementById('mslineagainst').checked) { qag=1; }
    if (document.getElementById('mslinenone').checked) { qnone=1; }

	sendMslineData(dated,datef,qen,qfr,qit,qde,qsp,qfor,qag,qnone);
}

function sendMslineData(dated,datef,qen,qfr,qit,qde,qsp,qfor,qag,qnone){

xmlhttp2 = new XMLHttpRequest();
xmlhttp2.onreadystatechange = function() {
     if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
         console.log(xmlhttp2.responseText);
         loadChart("txt_files/datasentimentmsline.txt");
     }
};
xmlhttp2.open("POST","getData/getSentimentMslineData.php",true);
xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp2.send(
"&dd=" + dated + "&df=" + datef 
+ "&en=" + qen + "&fr=" + qfr + "&it=" + qit + "&de=" + qde + "&sp=" + qsp 
+ "&for=" + qfor + "&ag=" + qag + "&none=" + qnone
);
}