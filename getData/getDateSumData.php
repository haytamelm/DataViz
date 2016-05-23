<?php

include 'connectdb.php';

$dd = $_POST['dd'];
$df = $_POST['df'];

//topic

$for = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND TOPIC_TWEET = 'For_eu';"
                      )->fetch_row()[0];
                      
$against = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND TOPIC_TWEET = 'Against_eu';"
                      )->fetch_row()[0];                     

$none = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND TOPIC_TWEET = 'None';"
                      )->fetch_row()[0];
                      
//language

$en = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND LANGUAGE_TWEET = 'english';"
                      )->fetch_row()[0];
                      
$fr = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND LANGUAGE_TWEET = 'french';"
                      )->fetch_row()[0];

$it = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND LANGUAGE_TWEET = 'italia';"
                      )->fetch_row()[0];

$de = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND LANGUAGE_TWEET = 'deutche';"
                      )->fetch_row()[0];

$sp = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND LANGUAGE_TWEET = 'spanish';"
                      )->fetch_row()[0];                      




//sentiment

$positive = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND SENTIMENT_TWEET = 'positive';"
                      )->fetch_row()[0];
                      
$negative = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND SENTIMENT_TWEET = 'negative';"
                      )->fetch_row()[0];                     

$neutral = $conn->query("SELECT COUNT(*) 
                       FROM TWEET
                       WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                       AND SENTIMENT_TWEET = 'neutral';"
                      )->fetch_row()[0];



//hashtags

$top_hashtags = $conn->query("SELECT TXT_HASHTAG,COUNT(*) AS NUM
                         FROM hashtag
                         JOIN tweet ON hashtag.ID_TWEET = tweet.ID_TWEET
                         WHERE (DATE_TWEET BETWEEN '$dd' AND '$df')
                         GROUP BY TXT_HASHTAG
                         ORDER BY NUM DESC
                         LIMIT 10;"
                        )->fetch_all();

for($i = 0, $hashtags=""; $i < 10; $i++)
{
   $hashtags .= $top_hashtags[$i][0]."&emsp;".$top_hashtags[$i][1]."<br/>";
}
                      
echo $for.",".$against.",".$none.",".$en.",".$fr.",".$it.",".$de.",".$sp.",".$positive.",".$negative.",".$neutral."|".$hashtags;

?>