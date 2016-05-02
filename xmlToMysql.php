<?php
session_start();

$z = new XMLReader;
$z->open($_SESSION["uploadfile"]);

include 'connectdb.php';

$doc = new DOMDocument;

// move to the first <tweet /> node
while ($z->read() && $z->name !== 'tweet');

// now that we're at the right depth, hop to the next <tweet/> until the end of the tree
while ($z->name === 'tweet')
{
    // DOM 
    $tweet = simplexml_import_dom($doc->importNode($z->expand(), true));

    // now you can use $node without going insane about parsing
	$id_tweet = $tweet['id'];
	$txt_tweet = $tweet['txt'];
	$language_tweet = $tweet->languages['id'];
	$sentiment_tweet = $tweet->sentiments['id'];
	$topic_tweet = $tweet->topics['id'];
	
	// vider les tables avant d'inserer
	$conn->query("TRUNCATE TABLE 'hashtag'"); 
	$conn->query("DELETE FROM 'tweet' WHERE 1");
	
	//echo $id_tweet.' '.$txt_tweet.' '.$language_tweet.' '.$sentiment_tweet.' '.$topic_tweet.'<br/><br/>';
	echo '<br/><br/>';
	
	$sql =  "INSERT INTO `tweet`(`ID_TWEET`, `TXT_TWEET`, `LANGUAGE_TWEET`, `SENTIMENT_TWEET`, `TOPIC_TWEET`) 
			 VALUES ($id_tweet,'$txt_tweet','$language_tweet','$sentiment_tweet','$topic_tweet')";
	
	if($conn->query($sql)){
		echo 'insertion dans la table tweet bien effectuée<br/>';
	}
	else{
		echo "erreur d'insertion dans la table tweet<br/>";
	}
			 
	foreach($tweet->hashtags->hashtag as $hashtag){
		$hashtagscore = $hashtag['score'];
		$sql2 =  "INSERT INTO `hashtag`(`ID_TWEET`, `TXT_HASHTAG`, `SCORE_HASHTAG`) 
			      VALUES ($id_tweet,'$hashtag',$hashtagscore)";
		if($conn->query($sql2)){
			echo 'insertion dans la table hashtag bien effectuée<br/>';
		}
		else{
			echo "erreur d'insertion dans la table hashtag<br/>";
		}
	}
	
    // go to next <tweet/>
    $z->next('tweet');
}

$conn->close();

header('Location: piechart.php');

?>