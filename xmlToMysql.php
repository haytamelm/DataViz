<?php
session_start();
$time_start = microtime(true);
ini_set('max_execution_time', 300);
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);


include 'connectdb.php';

$conn->query("DELETE FROM tweet");

$tweet_insert = '';
$hashtag_insert = '';
$fcontent_tweet = '';
$fcontent_hashtag = '';

$myfile = fopen("tweetsfile.txt", "a") or die("Unable to open file!");

$nbfiles = count($_SESSION["uploadfiles"]);

for($i = 0; $i < $nbfiles; $i++)
{

$reader = new XMLReader;
$reader->open($_SESSION["uploadfiles"][$i]);

$filename = basename($_SESSION["uploadfiles"][$i]);
$date_tweet = explode('__',$filename)[0];

// move to the first <tweet /> node
//while ($reader->read() && $reader->name !== 'tweet');

// vider les tables avant d'inserer
$hashtagsarr = [];

// now that we're at the right depth, hop to the next <tweet/> until the end of the tree
while ($reader->read())
{
    // take action based on the kind of node returned
   switch($reader->nodeType) {
       // read more http://uk.php.net/manual/en/class.xmlreader.php#xmlreader.constants.element
       case (XMLREADER::ELEMENT):
              // get the name of the node.
              $node_name  = $reader->name;
			  switch($node_name){
				case 'tweet':
					$id_tweet = $reader->getAttribute('id');
					$txt_tweet = $reader->getAttribute('txt');
					break;
				case 'languages':
					 $language_tweet = $reader->getAttribute('id');
					break;
				case 'sentiments':
					$sentiment_tweet = $reader->getAttribute('id');
					break;
				case 'topics':
					$topic_tweet = $reader->getAttribute('id');
					break;
				case 'hashtag':
					$hashtagsarr[] = $reader->readString();
					break;
				}
              // move the pointer to read the next item
              $reader->read();
              // action based on the $node_name
           break;
       case (XMLREADER::END_ELEMENT):
            // do something based on when the element closes.
			if($reader->name == 'tweet'){
				// tweet
				/*$tweet_insert .=  sprintf("INSERT INTO `tweet`(`ID_TWEET`, `TXT_TWEET`, `DATE_TWEET`, `LANGUAGE_TWEET`, `SENTIMENT_TWEET`, `TOPIC_TWEET`) 
				VALUES ('%d','%s','%s','%s','%s','%s');",
				$id_tweet,
				$txt_tweet,
				$date_tweet,
				$language_tweet,
				$sentiment_tweet,
				$topic_tweet);*/
				
				$fcontent_tweet .= $id_tweet."\t".$txt_tweet."\t".$date_tweet."\t".$language_tweet."\t".$sentiment_tweet."\t".$topic_tweet."\n";
				
				
				// hashtags
				
				/*for($i = 0; $i < count($hashtagsarr); $i++ ){
					//$hashtagscore = 0;
					$hashtg = $hashtagsarr[$i];
					$hashtag_insert .=  sprintf("INSERT INTO `hashtag`(`ID_TWEET`, `TXT_HASHTAG`, `SCORE_HASHTAG`) 
							  VALUES ('%d','%s',0); ",
							  $id_tweet,
							  $hashtg
							  );
					//$fcontent_hashtag .= $id_tweet."\t".$hashtg."\t".'0\n';
							  
				}
				$hashtagsarr = array();*/
				
				
				
			}
            break;
   }
}

				fwrite($myfile, $fcontent_tweet);
				$fcontent_tweet = "";

}


if(!$conn->query("LOAD DATA INFILE '/xamppp/htdocs/DataViz/tweetsfile.txt' INTO TABLE tweet;")) 
	echo "tweet: ".$conn->error."<br/>";
	
fclose($myfile);

/*if(!mysqli_multi_query($conn,$hashtag_insert)) 
	echo "hash: ".mysqli_error($conn)."<br/>";*/

$conn->close();
$time_end = microtime(true);
$time = $time_end - $time_start;
echo "fini pendant ".sprintf("%.2f",$time)." secondes";

//header('Location: piechart.php');

?>