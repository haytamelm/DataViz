<?php
if(!empty($_POST))
{
    include 'connectdb.php';

    $positive = 0;
    $negative = 0;
    $neutral = 0;

    $dd = $_POST['dd'];
    $df = $_POST['df'];
    
    $qarrlanguages = [];
    $qarrtopics = [];
    
    // 
    if(intval($_POST['en']) == 1) { $qarrlanguages[] = "'english'"; }
    if(intval($_POST['fr']) == 1) { $qarrlanguages[] = "'french'"; }
    if(intval($_POST['it']) == 1) { $qarrlanguages[] = "'italia'"; }
    if(intval($_POST['de']) == 1) { $qarrlanguages[] = "'deutche'"; }
    if(intval($_POST['sp']) == 1) { $qarrlanguages[] = "'spanish'"; }
    
    $qlanguages = implode(",", $qarrlanguages);
    
    //
    if(intval($_POST['qfor']) == 1) { $qarrtopics[] = "'For_eu'"; }
    if(intval($_POST['qagainst']) == 1) { $qarrtopics[] = "'Against_eu'"; }
    if(intval($_POST['qnone']) == 1) { $qarrtopics[] = "'None'"; }
    
    $qtopics = implode(",", $qarrtopics);
    
	//
    if(intval($_POST['po']) == 1)
    {
        $positive = $conn->query("SELECT COUNT(*) 
                                  FROM TWEET
                                  IGNORE INDEX(all_tweet)
                                  WHERE TOPIC_TWEET IN (".$qtopics.")
                                  AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                                  AND LANGUAGE_TWEET IN (".$qlanguages.")
                                  AND SENTIMENT_TWEET = 'positive';"
                                 )->fetch_row()[0];
	}
	
    if(intval($_POST['neg']) == 1)
    {
        $negative = $conn->query("SELECT COUNT(*)
                                  FROM TWEET
                                  IGNORE INDEX(all_tweet)
                                  WHERE TOPIC_TWEET IN (".$qtopics.")
                                  AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                                  AND LANGUAGE_TWEET IN (".$qlanguages.")
                                  AND SENTIMENT_TWEET = 'negative';"
                                 )->fetch_row()[0];
	}
	
    if(intval($_POST['neu']) == 1)
    {
        $neutral = $conn->query("SELECT COUNT(*)
                                 FROM TWEET
                                 IGNORE INDEX(all_tweet)
                                 WHERE TOPIC_TWEET IN (".$qtopics.")
                                 AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                                 AND LANGUAGE_TWEET IN (".$qlanguages.")
                                 AND SENTIMENT_TWEET = 'neutral';"
                                )->fetch_row()[0];
    }
	
    echo $positive.",".$negative.",".$neutral;

    $conn->close();	
}
else
{
    header('location: index.php');
}



?>