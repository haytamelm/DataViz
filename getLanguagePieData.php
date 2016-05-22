<?php
if(!empty($_POST))
{
    include 'connectdb.php';

    $en = 0;
    $fr = 0;
    $it = 0;
    $de = 0;
    $sp = 0;

    $dd = $_POST['dd'];
    $df = $_POST['df'];
    
    $qarrtopics = [];
    $qarrsentiments = [];
    
    // 
    if(intval($_POST['qfor']) == 1) { $qarrtopics[] = "'For_eu'"; }
    if(intval($_POST['qagainst']) == 1) { $qarrtopics[] = "'Against_eu'"; }
    if(intval($_POST['qnone']) == 1) { $qarrtopics[] = "'None'"; }
    
    $qtopics = implode(",", $qarrtopics);
    
    //
    if(intval($_POST['po']) == 1) { $qarrsentiments[] = "'positive'"; }
    if(intval($_POST['neg']) == 1) { $qarrsentiments[] = "'negative'"; }
    if(intval($_POST['neu']) == 1) { $qarrsentiments[] = "'neutral'"; }
    
    $qsentiments = implode(",", $qarrsentiments);
    
	//
    if(intval($_POST['en']) == 1)
    {
        $en = $conn->query("SELECT COUNT(*) 
                              FROM TWEET 
                              IGNORE INDEX (all_tweet_index)
                              WHERE TOPIC_TWEET IN (".$qtopics.")
                              AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                              AND LANGUAGE_TWEET = 'english'
                              AND SENTIMENT_TWEET IN (".$qsentiments.");"
                            )->fetch_row()[0];
	}
	
    if(intval($_POST['fr']) == 1)
    {
        $fr = $conn->query("SELECT COUNT(*) 
                              FROM TWEET 
                              IGNORE INDEX (all_tweet_index)
                              WHERE TOPIC_TWEET IN (".$qtopics.")
                              AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                              AND LANGUAGE_TWEET = 'french'
                              AND SENTIMENT_TWEET IN (".$qsentiments.");"
                            )->fetch_row()[0];
	}
	
    if(intval($_POST['it']) == 1)
    {
        $it = $conn->query("SELECT COUNT(*) 
                              FROM TWEET 
                              IGNORE INDEX (all_tweet_index)
                              WHERE TOPIC_TWEET IN (".$qtopics.")
                              AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                              AND LANGUAGE_TWEET = 'italia'
                              AND SENTIMENT_TWEET IN (".$qsentiments.");"
                            )->fetch_row()[0];
	}
    
    if(intval($_POST['de']) == 1)
    {
        $de = $conn->query("SELECT COUNT(*) 
                              FROM TWEET 
                              IGNORE INDEX (all_tweet_index)
                              WHERE TOPIC_TWEET IN (".$qtopics.")
                              AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                              AND LANGUAGE_TWEET = 'deutche'
                              AND SENTIMENT_TWEET IN (".$qsentiments.");"
                            )->fetch_row()[0];
	}
    
    if(intval($_POST['sp']) == 1)
    {
        $sp = $conn->query("SELECT COUNT(*) 
                              FROM TWEET 
                              IGNORE INDEX (all_tweet_index)
                              WHERE TOPIC_TWEET IN (".$qtopics.")
                              AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                              AND LANGUAGE_TWEET = 'spanish'
                              AND SENTIMENT_TWEET IN (".$qsentiments.");"
                            )->fetch_row()[0];
	}
	
    echo $en.",".$fr.",".$it.",".$de.",".$sp;

    $conn->close();	
}
else
{
    header('location: index.php');
}



?>