	<?php

	include 'connectdb.php';

	$tags = (isset($_POST["tags"])) ? htmlentities($_POST["tags"]) : NULL;
	$dd = (isset($_POST["dd"])) ? htmlentities($_POST["dd"]) : NULL;
	$df = (isset($_POST["df"])) ? htmlentities($_POST["df"]) : NULL;

	$total1 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df') 
			AND TWEET.TOPIC_TWEET='None'")->fetch_row()[0];

	$total2 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			AND (DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TOPIC_TWEET='For_eu'")->fetch_row()[0];

	$total3 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TWEET.TOPIC_TWEET='Against_eu'")->fetch_row()[0];


	$tag = explode(",", $tags);
	$data="[\n";

	for ($i=0; $i < count($tag); $i++) { 
		$tagi = $tag[$i];
		$vale1 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			WHERE  TXT_HASHTAG = '$tagi' 
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df') 
			AND TWEET.TOPIC_TWEET='None'")->fetch_row()[0];
		$vale1 = $vale1/$total1;
		$vale2 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			WHERE  TXT_HASHTAG = '$tagi' 
			AND (DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TOPIC_TWEET='For_eu'")->fetch_row()[0];
		$vale2 = $vale2/$total2;
		$vale3 = $conn->query("SELECT COUNT(distinct HASHTAG.ID_TWEET) 
			FROM HASHTAG 
			JOIN TWEET on HASHTAG.ID_TWEET = TWEET.ID_TWEET
			WHERE  TXT_HASHTAG = '$tagi' 
			AND (TWEET.DATE_TWEET BETWEEN '$dd' AND '$df' )
			AND TWEET.TOPIC_TWEET='Against_eu'")->fetch_row()[0];
		$vale3 = $vale3/$total3;

		if($vale1==0 && $vale2==0 && $vale3==0){
			$data .="";
		}else{
			$data .="["
		. "{\"axis\":\"None\",\"value\":'".$vale1."'},\n"
		. "{\"axis\":\"Against_eu\",\"value\":'".$vale2."'},\n"
		. "{\"axis\":\"For_eu\",\"value\":'".$vale3."'}]\n";

			if ($i != count($tag)-1) {
				$data.=",\n";
			};
		}

	}

	$data.= "\n]";
	echo $data;


	?>