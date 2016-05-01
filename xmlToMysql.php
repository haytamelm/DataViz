<?php
session_start();

$z = new XMLReader;
$z->open($_SESSION["uploadfile"]);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dataviz";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doc = new DOMDocument;

// move to the first <tweet /> node
while ($z->read() && $z->name !== 'tweet');

// now that we're at the right depth, hop to the next <tweet/> until the end of the tree
while ($z->name === 'tweet')
{
    // either one should work
    //$node = new SimpleXMLElement($z->readOuterXML());
    $tweet = simplexml_import_dom($doc->importNode($z->expand(), true));

    // now you can use $node without going insane about parsing
	$id_tweet = $tweet['id'];
	$txt_tweet = $tweet['txt'];
	$language_tweet = $tweet->languages['id'];
	$sentiment_tweet = $tweet->sentiments['id'];
	$topic_tweet = $tweet->topics['id'];
	
	$conn->query("delete from 'hashtag'");
	$conn->query("delete from 'tweet'");
	
	//echo $id_tweet.' '.$txt_tweet.' '.$language_tweet.' '.$sentiment_tweet.' '.$topic_tweet.'<br/><br/>';
	echo '<br/><br/>';
	
	$sql =  "INSERT INTO `tweet`(`ID_TWEET`, `TXT_TWEET`, `LANGUAGE_TWEET`, `SENTIMENT_TWEET`, `TOPIC_TWEET`) 
			 VALUES ($id_tweet,'$txt_tweet','$language_tweet','$sentiment_tweet','$topic_tweet')";
	
	$conn->query($sql);
			 
	foreach($tweet->hashtags->hashtag as $hashtag){
		$hashtagscore = $hashtag['score'];
		$sql2 =  "INSERT INTO `hashtag`(`ID_TWEET`, `TXT_HASHTAG`, `SCORE_HASHTAG`) 
			      VALUES ($id_tweet,'$hashtag',$hashtagscore)";
		$conn->query($sql2);
	}
	
    // go to next <tweet/>
    $z->next('tweet');
}

$conn->close();

?>