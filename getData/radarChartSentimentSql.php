	<?php

	include 'connectdb.php';

	$tags = (isset($_POST["tags"])) ? htmlentities($_POST["tags"]) : NULL;
	$dd = (isset($_POST["dd"])) ? htmlentities($_POST["dd"]) : NULL;
	$df = (isset($_POST["df"])) ? htmlentities($_POST["df"]) : NULL;

	$total1 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df') 
			AND TWEET.SENTIMENT_TWEET='neutral'")->fetch_row()[0];

	$total2 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TWEET.SENTIMENT_TWEET='positive'")->fetch_row()[0];

	$total3 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TWEET.SENTIMENT_TWEET='negative'")->fetch_row()[0];


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
			AND TWEET.SENTIMENT_TWEET='neutral'")->fetch_row()[0];
		$vale1 = $vale1/$total1;

		$vale2 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			WHERE  TXT_HASHTAG = '$tagi' 
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TWEET.SENTIMENT_TWEET='positive'")->fetch_row()[0];
		$vale2 = $vale2/$total2;

		$vale3 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			WHERE  TXT_HASHTAG = '$tagi' 
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TWEET.SENTIMENT_TWEET='negative'")->fetch_row()[0];
		$vale3 = $vale3/$total3;


	if($vale1<$vale2){
		$max1=$vale2;
		if ($max1<$vale3) {
			$max1=$vale3;
		}
	}else{
		$max1=$vale1;
		if ($max1<$vale3) {
			$max1=$vale3;
		}
	}

	if ($max1>$max2) {
		$max2=$max1;
	}

		if($vale1==0 && $vale2==0 && $vale3==0){

			$data .="";

		}else{

			$legend .=$tagi;
			$data .="["
			. "{\"axis\":\"neutral\",\"value\":'".$vale1."'},\n"
			. "{\"axis\":\"positive\",\"value\":'".$vale2."'},\n"
			. "{\"axis\":\"negative\",\"value\":'".$vale3."'}]\n";

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