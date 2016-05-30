	<?php

	include 'connectdb.php';

	$tags = (isset($_POST["tags"])) ? htmlentities($_POST["tags"]) : NULL;
	$dd = (isset($_POST["dd"])) ? htmlentities($_POST["dd"]) : NULL;
	$df = (isset($_POST["df"])) ? htmlentities($_POST["df"]) : NULL;

	$total1 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
		FROM HASHTAG 
		JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
		AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df') 
		AND TWEET.LANGUAGE_TWEET='english'")->fetch_row()[0];

	$total2 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
		FROM HASHTAG 
		JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
		AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
		AND TWEET.LANGUAGE_TWEET='spanish'")->fetch_row()[0];

	$total3 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
		FROM HASHTAG 
		JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
		AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
		AND TWEET.LANGUAGE_TWEET='deutche'")->fetch_row()[0];

	$total4 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
		FROM HASHTAG 
		JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
		AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
		AND TWEET.LANGUAGE_TWEET='french'")->fetch_row()[0];

	$total5 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
		FROM HASHTAG 
		JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
		AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
		AND TWEET.LANGUAGE_TWEET='italia'")->fetch_row()[0];


	$tag = explode(",", $tags);
	$data="[\n";
	$legend="";
	$max2=0;
	$max1=0;

	for ($i=0; $i < count($tag); $i++) { 
		$tagi = $tag[$i];

		$vale1 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			WHERE  TXT_HASHTAG = '$tagi' 
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df') 
			AND TWEET.LANGUAGE_TWEET='english'")->fetch_row()[0];
		$vale1 = $vale1/$total1;

		$vale2 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			WHERE  TXT_HASHTAG = '$tagi' 
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TWEET.LANGUAGE_TWEET='spanish'")->fetch_row()[0];
		$vale2 = $vale2/$total2;

		$vale3 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			WHERE  TXT_HASHTAG = '$tagi' 
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TWEET.LANGUAGE_TWEET='deutche'")->fetch_row()[0];
		$vale3 = $vale3/$total3;

		$vale4 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			WHERE  TXT_HASHTAG = '$tagi' 
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TWEET.LANGUAGE_TWEET='french'")->fetch_row()[0];
		$vale4 = $vale4/$total4;

		$vale5 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			WHERE  TXT_HASHTAG = '$tagi' 
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TWEET.LANGUAGE_TWEET='italia'")->fetch_row()[0];
		$vale5 = $vale5/$total5;




	$max1=max($vale1,$vale2,$vale3,$vale4,$vale5);
	// if($vale1<$vale2){
	// 	$max1=$vale2;
	// 	if ($max1<$vale3) {
	// 		$max1=$vale3;
	// 	}else if ($max1<$vale4) {
	// 		$max1=$vale4
	// 	}
	// }else{
	// 	$max1=$vale1;
	// 	if ($max1<$vale3) {
	// 		$max1=$vale3;
	// 	}
	// }

	if ($max1>$max2) {
		$max2=$max1;
	}


	if($vale1==0 && $vale2==0 && $vale3==0){

		$data .="";

	}else{

		$legend .=$tagi;
		$data .="["
		. "{\"axis\":\"english\",\"value\":'".$vale1."'},\n"
		. "{\"axis\":\"spanish\",\"value\":'".$vale2."'},\n"
		. "{\"axis\":\"deutche\",\"value\":'".$vale3."'},\n"
		. "{\"axis\":\"french\",\"value\":'".$vale4."'},\n"
		. "{\"axis\":\"italia\",\"value\":'".$vale5."'}]\n";

		if ($i != (count($tag)-1)){
			$data.=",\n";
			$legend .=";";
		}else{
			$data.="";
			$legend .="";
		}
	}
}
	if( $legend{strlen($legend)-1} == ';')
	{
   $legend = substr($legend, 0, strlen($legend)-1); 
	}
$max2=round($max2, 1);
$data.= "\n]";
echo $data;
echo "aaaa";
echo $legend;
echo "aaaa";
echo $max2;

	?>