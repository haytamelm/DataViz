<?php

include 'connectdb.php';

$data_text = "date\tnone\tfor\tagainst";

$date = date_create($_POST['dd']);
$maxdate = date_create($_POST['df']);

while($date < $maxdate)
{
date_add($date, date_interval_create_from_date_string('1 days'));
$datet = date_format($date, 'Ymd');

$none = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'None' AND DATE_TWEET = '$datet';")->fetch_row()[0];
$for_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'For_eu' AND DATE_TWEET = '$datet';")->fetch_row()[0];
$against_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'Against_eu' AND DATE_TWEET = '$datet';")->fetch_row()[0];

$data_text .= "\n".$datet."\t".$none."\t".$for_eu."\t".$against_eu;
}

$dfile = fopen("datax.txt", "w") or die("Unable to open file!");
fwrite($dfile, $data_text);
fclose($dfile);
$conn->close();

echo 'ready';


?>