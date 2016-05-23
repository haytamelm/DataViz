
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
    
	var qfor=0, qag=0, qnone=0, 
       qde=0, qsp=0, qpo=0, qneg=0, qneu=0;
    
    if (document.getElementById('mslinefor').checked) { qfor=1; }
    if (document.getElementById('mslineagainst').checked) { qag=1; }
    if (document.getElementById('mslinenone').checked) { qnone=1; }
    if (document.getElementById('mslinepositive').checked) { qpo=1; }
    if (document.getElementById('mslinenegative').checked) { qneg=1; }
    if (document.getElementById('mslineneutral').checked) { qneu=1; }

	sendMslineData(dated,datef,qfor,qag,qnone,qpo,qneg,qneu);
}

function sendMslineData(dated,datef,qfor,qag,qnone,qpo,qneg,qneu){

xmlhttp2 = new XMLHttpRequest();
xmlhttp2.onreadystatechange = function() {
     if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
         console.log(xmlhttp2.responseText);
         loadChart("txt_files/datalanguagemsline.txt");
     }
};
xmlhttp2.open("POST","getData/getLanguageMslineData.php",true);
xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp2.send(
"&dd=" + dated + "&df=" + datef 
+ "&for=" + qfor + "&ag=" + qag + "&none=" + qnone
+ "&po=" + qpo + "&neg=" + qneg + "&neu=" + qneu
);
}