<?php

include 'connectdb.php';

if(empty($_GET))
{
$none = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'None';")->fetch_row()[0];
$for_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'For_eu';")->fetch_row()[0];
$against_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'Against_eu';")->fetch_row()[0];
}
else
{
$dd = $_GET['dd'];$df = $_GET['df'];
$none = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'None' AND ( DATE_TWEET BETWEEN '$dd' AND '$df' );")->fetch_row()[0];
$for_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'For_eu' AND ( DATE_TWEET BETWEEN '$dd' AND '$df' );")->fetch_row()[0];
$against_eu = $conn->query("SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'Against_eu' AND ( DATE_TWEET BETWEEN '$dd' AND '$df' );")->fetch_row()[0];
}

echo $none.",".$for_eu.",".$against_eu;

$conn->close();

?>