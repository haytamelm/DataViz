
function refresh(){
	document.getElementById("error").innerHTML = '';
	var dated = document.getElementById('dateDeb').value;
	if(dated==''){
	  document.getElementById("error").innerHTML = "date debut est vide";
	  return 0;}
	var datef = document.getElementById('dateFin').value;
	if(datef==''){
	  document.getElementById("error").innerHTML = "date fin est vide";
	  return 0;}
	if(datef < dated){
	  document.getElementById("error").innerHTML = "date fin doit étre supérieure à date debut";
	  return 0;}
      
	sendDateSumData(dated,datef);
}

function sendDateSumData(dated,datef){

xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         reponse = (xmlhttp.responseText).split("|");
         var values = reponse[0].split(",");
         console.log(reponse[1]);
         
         document.getElementById('for').innerHTML = 'For:\t'+values[0];
         document.getElementById('aga').innerHTML = 'Against:\t'+values[1];
         document.getElementById('none').innerHTML = 'Against:\t'+values[2];
         
         document.getElementById('en').innerHTML = 'English:\t'+values[3];
         document.getElementById('fr').innerHTML = 'French:\t'+values[4];
         document.getElementById('it').innerHTML = 'Italia:\t'+values[5];
         document.getElementById('de').innerHTML = 'Deutche:\t'+values[6];
         document.getElementById('sp').innerHTML = 'Spanish:\t'+values[7];
         
         document.getElementById('pos').innerHTML = 'Positive:\t'+values[8];
         document.getElementById('neg').innerHTML = 'Negative:\t'+values[9];
         document.getElementById('neu').innerHTML = 'Neutral:\t'+values[10];
         
         document.getElementById('tophash').innerHTML = reponse[1];
     }
};
xmlhttp.open("POST","getData/getDateSumData.php",true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("&dd="+dated+"&df="+datef);
}