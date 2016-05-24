<?php
if(!empty($_POST))
{
    include 'connectdb.php';

    $none = 0;
    $for_eu = 0;
    $against_eu = 0;

    $dd = $_POST['dd'];
    $df = $_POST['df'];
    
    $qarrlanguages = [];
    $qarrsentiments = [];
    
    // 
    if(intval($_POST['en']) == 1) { $qarrlanguages[] = "'english'"; }
    if(intval($_POST['fr']) == 1) { $qarrlanguages[] = "'french'"; }
    if(intval($_POST['it']) == 1) { $qarrlanguages[] = "'italia'"; }
    if(intval($_POST['de']) == 1) { $qarrlanguages[] = "'deutche'"; }
    if(intval($_POST['sp']) == 1) { $qarrlanguages[] = "'spanish'"; }
    
    $qlanguages = implode(",", $qarrlanguages);
    
    //
    if(intval($_POST['po']) == 1) { $qarrsentiments[] = "'positive'"; }
    if(intval($_POST['neg']) == 1) { $qarrsentiments[] = "'negative'"; }
    if(intval($_POST['neu']) == 1) { $qarrsentiments[] = "'neutral'"; }
    
    $qsentiments = implode(",", $qarrsentiments);
    
	//
    if(intval($_POST['qnone']) == 1)
    {
        $none = $conn->query("SELECT COUNT(*) 
                              FROM TWEET
                              IGNORE INDEX(all_tweet)
                              WHERE TOPIC_TWEET = 'None'
                              AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                              AND LANGUAGE_TWEET IN (".$qlanguages.")
                              AND SENTIMENT_TWEET IN (".$qsentiments.");"
                            )->fetch_row()[0];
	}
	
    if(intval($_POST['qfor']) == 1)
    {
        $for_eu = $conn->query("SELECT COUNT(*)
                                FROM TWEET
                                IGNORE INDEX(all_tweet)
                                WHERE TOPIC_TWEET = 'For_eu' 
                                AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                                AND LANGUAGE_TWEET IN (".$qlanguages.")
                                AND SENTIMENT_TWEET IN (".$qsentiments.");"
                              )->fetch_row()[0];
	}
	
    if(intval($_POST['qagainst']) == 1)
    {
        $against_eu = $conn->query("SELECT COUNT(*)
                                    FROM TWEET
                                    IGNORE INDEX(all_tweet)
                                    WHERE TOPIC_TWEET = 'Against_eu' 
                                    AND (DATE_TWEET BETWEEN '$dd' AND '$df')
                                    AND LANGUAGE_TWEET IN (".$qlanguages.")
                                    AND SENTIMENT_TWEET IN (".$qsentiments.");"
                                  )->fetch_row()[0];
    }
	
    echo $none.",".$for_eu.",".$against_eu;

    $conn->close();	
}
else
{
    header('location: index.php');
}



?>