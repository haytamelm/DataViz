<?php

include 'connectdb.php';

$data_text = "date\tnone\tfor\tagainst";

$date = date_create($_POST['dd']);
$maxdate = date_create($_POST['df']);

while($date <= $maxdate)
{
$datet = date_format($date, 'y-M-d');
$dater = date_format($date, 'Y-m-d');

$total = $conn->query("SELECT COUNT(*) FROM TWEET WHERE DATE_TWEET = '$dater';")->fetch_row()[0];
$none = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'None' AND DATE_TWEET = '$dater';")->fetch_row()[0];
$for_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'For_eu' AND DATE_TWEET = '$dater';")->fetch_row()[0];
$against_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'Against_eu' AND DATE_TWEET = '$dater';")->fetch_row()[0];

$data_text .= "\n".$datet."\t".(100)*intval($none)/intval($total)."\t".(100)*intval($for_eu)/intval($total)."\t".(100)*intval($against_eu)/intval($total);


date_add($date, date_interval_create_from_date_string('1 days'));
}

$dfile = fopen("datastack.txt", "w") or die("Unable to open file!");
fwrite($dfile, $data_text);
fclose($dfile);
$conn->close();

echo 'ready';


?>