<?php

include 'connectdb.php';

$data_text = "date\tpositive\tnegative\tneutral";

$date = date_create($_POST['dd']);
$maxdate = date_create($_POST['df']);

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
    if(intval($_POST['for']) == 1) { $qarrtopics[] = "'For_eu'"; }
    if(intval($_POST['ag']) == 1) { $qarrtopics[] = "'Against_eu'"; }
    if(intval($_POST['none']) == 1) { $qarrtopics[] = "'None'"; }
    
    $qtopics = implode(",", $qarrtopics);

while($date <= $maxdate)
{
    $dater = date_format($date, 'y-M-d');
    $datet = date_format($date, 'Y-m-d');

    $positive = $conn->query("SELECT COUNT(*) 
                          FROM TWEET 
                          WHERE TOPIC_TWEET IN (".$qtopics.") 
                          AND DATE_TWEET = '$datet'
                          AND LANGUAGE_TWEET IN (".$qlanguages.")
                          AND SENTIMENT_TWEET = 'positive';"
                          )->fetch_row()[0];
                          
    $negative = $conn->query("SELECT COUNT(*) 
                            FROM TWEET 
                            WHERE TOPIC_TWEET IN (".$qtopics.") 
                            AND DATE_TWEET = '$datet'
                            AND LANGUAGE_TWEET IN (".$qlanguages.")
                            AND SENTIMENT_TWEET = 'negative';"
                           )->fetch_row()[0];
                           
    $neutral = $conn->query("SELECT COUNT(*) 
                                FROM TWEET 
                                WHERE TOPIC_TWEET IN (".$qtopics.") 
                                AND DATE_TWEET = '$datet'
                                AND LANGUAGE_TWEET IN (".$qlanguages.")
                                AND SENTIMENT_TWEET = 'neutral';"
                                )->fetch_row()[0];

    $total = intval($positive)+ intval($negative)+ intval($neutral);

    $data_text .= "\n".$dater."\t".(100)*intval($positive)/intval($total)."\t".(100)*intval($negative)/intval($total)."\t".(100)*intval($neutral)/intval($total);

    date_add($date, date_interval_create_from_date_string('1 days'));
}

$dfile = fopen(dirname(__DIR__)."/txt_files/datasentimentstacked.txt", "w") or die("Unable to open file!");
fwrite($dfile, $data_text);
fclose($dfile);
$conn->close();

echo 'ready';


?>