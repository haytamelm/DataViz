﻿<?php

include 'connectdb.php';

$data_text = "date\tnone\tfor\tagainst";

$date = date_create($_POST['dd']);
$maxdate = date_create($_POST['df']);

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

while($date <= $maxdate)
{
    $dater = date_format($date, 'y-M-d');
    $datet = date_format($date, 'Y-m-d');

    $none = $conn->query("SELECT COUNT(*) 
                          FROM TWEET 
                          WHERE TOPIC_TWEET = 'None' 
                          AND DATE_TWEET = '$datet'
                          AND LANGUAGE_TWEET IN (".$qlanguages.")
                          AND SENTIMENT_TWEET IN (".$qsentiments.");"
                          )->fetch_row()[0];
                          
    $for_eu = $conn->query("SELECT COUNT(*) 
                            FROM TWEET 
                            WHERE TOPIC_TWEET = 'For_eu' 
                            AND DATE_TWEET = '$datet'
                            AND LANGUAGE_TWEET IN (".$qlanguages.")
                            AND SENTIMENT_TWEET IN (".$qsentiments.");"
                           )->fetch_row()[0];
                           
    $against_eu = $conn->query("SELECT COUNT(*) 
                                FROM TWEET 
                                WHERE TOPIC_TWEET = 'Against_eu' 
                                AND DATE_TWEET = '$datet'
                                AND LANGUAGE_TWEET IN (".$qlanguages.")
                                AND SENTIMENT_TWEET IN (".$qsentiments.");"
                                )->fetch_row()[0];

$total = intval($none)+ intval($for_eu)+ intval($against_eu);

$data_text .= "\n".$dater."\t".(100)*intval($none)/intval($total)."\t".(100)*intval($for_eu)/intval($total)."\t".(100)*intval($against_eu)/intval($total);

date_add($date, date_interval_create_from_date_string('1 days'));
}

$dfile = fopen(dirname(__DIR__)."/txt_files/datatopicstacked.txt", "w") or die("Unable to open file!");
fwrite($dfile, $data_text);
fclose($dfile);
$conn->close();

echo 'ready';


?>