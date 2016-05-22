	
	function refreshPie(){
	document.getElementById("pieerrors").innerHTML = '';
	var dated = document.getElementById('piedateDeb').value;
	if(dated==''){
	  document.getElementById("pieerrors").innerHTML = "date debut est vide";
	  return 0;}
	var datef = document.getElementById('piedateFin').value;
	if(datef==''){
	  document.getElementById("pieerrors").innerHTML = "date fin est vide";
	  return 0;}
	if(datef < dated){
	  document.getElementById("pieerrors").innerHTML = "date fin doit étre supérieure à date debut";
	  return 0;}
	nbChoixCoches = 0;
    
	var qfor=0,qagainst=0, qnone=0, qen=0, qfr=0, qit=0, 
       qde=0, qsp=0, qpoe=0, qneg=0, qneu=0;
    
	if (document.getElementById('pieagainst').checked) { nbChoixCoches++; qagainst=1; }
	if (document.getElementById('piefor').checked) { nbChoixCoches++; qfor=1; }
	if (document.getElementById('pienone').checked) { nbChoixCoches++; qnone=1; }
    if (document.getElementById('pieenglish').checked) { qen=1; }
    if (document.getElementById('piefrench').checked) { qfr=1; }
    if (document.getElementById('pieitalia').checked) { qit=1; }
    if (document.getElementById('piedeutche').checked) { qde=1; }
    if (document.getElementById('piespanish').checked) { qsp=1; }
    if (document.getElementById('piepositive').checked) { qpo=1; }
    if (document.getElementById('pienegative').checked) { qneg=1; }
    if (document.getElementById('pieneutral').checked) { qneu=1; }
    
	if(nbChoixCoches < 2 ){
	   document.getElementById("pieerrors").innerHTML = 'cochez au moins 2 choix';
	   return 0;
	}
	sendPieData(dated,datef,qfor,qagainst,qnone,qen,qfr,qit,qde,qsp,qpo,qneg,qneu);
}

function sendPieData(dated,datef,qfor,qagainst,qnone,qen,qfr,qit,qde,qsp,qpo,qneg,qneu){

xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         reponse = xmlhttp.responseText;
         console.log(reponse);
		 reponses = reponse.split(",");
		 var numNone = reponses[0];
		 var numFor = reponses[1];
		 var numAgainst = reponses[2];
		 loadPie(numNone,numFor,numAgainst);
     }
};
xmlhttp.open("POST","getTopicPieData.php",true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send(
"qfor=" + qfor + "&qagainst=" + qagainst + "&qnone=" + qnone 
+ "&dd=" + dated + "&df=" + datef 
+ "&en=" + qen + "&fr=" + qfr + "&it=" + qit + "&de=" + qde + "&sp=" + qsp 
+ "&po=" + qpo + "&neg=" + qneg + "&neu=" + qneu
);
}