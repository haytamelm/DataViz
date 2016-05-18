<?php

include 'connectdb.php';

$none = 0;
$for_eu = 0;
$against_eu = 0;

if(empty($_POST))
{
$none = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'None';")->fetch_row()[0];
$for_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'For_eu';")->fetch_row()[0];
$against_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'Against_eu';")->fetch_row()[0];
}
else
{
$dd = $_POST['dd'];$df = $_POST['df'];
if(intval($_POST['qnone']) == 1)
	$none = $conn->query("SELECT COUNT(*) FROM TWEET USE INDEX (date_topic_tweet_index) WHERE TOPIC_TWEET = 'None' AND ( DATE_TWEET BETWEEN '$dd' AND '$df' );")->fetch_row()[0];
if(intval($_POST['qfor']) == 1)
	$for_eu = $conn->query("SELECT COUNT(*) FROM TWEET USE INDEX (date_topic_tweet_index) WHERE TOPIC_TWEET = 'For_eu' AND ( DATE_TWEET BETWEEN '$dd' AND '$df' );")->fetch_row()[0];
if(intval($_POST['qagainst']) == 1)
	$against_eu = $conn->query("SELECT COUNT(*) FROM TWEET USE INDEX (date_topic_tweet_index) WHERE TOPIC_TWEET = 'Against_eu' AND ( DATE_TWEET BETWEEN '$dd' AND '$df' );")->fetch_row()[0];
}

echo $none.",".$for_eu.",".$against_eu;

$conn->close();

?>