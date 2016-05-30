<?php
session_start();

if($_SESSION["upass"] != 1)
header('Location: index.php');

ini_set('max_execution_time', 1200);
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

// connection bd
include 'connectdb.php';

$fcontent_tweet = '';
$fcontent_hashtag = '';

if (!file_exists('txt_files/')) {
    mkdir('txt_files/', 0777, true);
}

$myfile = fopen("txt_files/tweetsfile.txt", "a") or die("Unable to open file!");
$myfile2 = fopen("txt_files/hashtagsfile.txt", "a") or die("Unable to open file!");

$nbfiles = count($_SESSION["uploadfiles"]);

for($i = 0; $i < $nbfiles; $i++)
{
    // parsing
    $reader = new XMLReader;
    $reader->open($_SESSION["uploadfiles"][$i]);

    $filename = basename($_SESSION["uploadfiles"][$i]);
    $date_tweet = explode('__',$filename)[0]; // extraire la date du tweet depuis le nom du fichier xml

    // array des hashtags
    $hashtagsarr = [];

    // on commence a lire dans le <tweet>
    while ($reader->read())
    {
        // take action based on the kind of node returned
        switch($reader->nodeType) { 
            case (XMLREADER::ELEMENT): // get the name of the node.
                $node_name  = $reader->name;
                switch($node_name){
                    case 'tweet':
                        $id_tweet = $reader->getAttribute('id');
                        break;
                    case 'languages':
                        $language_tweet = $reader->getAttribute('id');
                        break;
                    case 'sentiments':
                        $sentiment_tweet = $reader->getAttribute('id');
                        break;
                    case 'topics':
                        $topic_tweet = $reader->getAttribute('id');
                        break;
                    case 'hashtag':
                        $hashtagsarr[] = $reader->readString();
                        break;
                }
                // move the pointer to read the next item
                $reader->read();
                break;
            case (XMLREADER::END_ELEMENT):
            // do something based on when the element closes.
                if($reader->name == 'tweet'){                
                    $fcontent_tweet .= $id_tweet."\t".$date_tweet."\t".$language_tweet."\t".$sentiment_tweet."\t".$topic_tweet."\n";
                    
                    for($j = 0; $j < count($hashtagsarr); $j++){
                        $hashtg = $hashtagsarr[$j];
                        $fcontent_hashtag .= $id_tweet."\t".$hashtg."\n";		  
                    }
                    $hashtagsarr = array();   
                }
            break;
        }
    }
    fwrite($myfile, $fcontent_tweet);
    $fcontent_tweet = "";
    fwrite($myfile2, $fcontent_hashtag);
    $fcontent_hashtag = "";
}

$hcwd = str_replace('\\', '/',getcwd()).'/txt_files/hashtagsfile.txt';
$tcwd = str_replace('\\', '/',getcwd()).'/txt_files/tweetsfile.txt';

if(!$conn->query(
            "LOAD DATA INFILE '".$tcwd."' IGNORE INTO TABLE tweet(ID_TWEET,DATE_TWEET,LANGUAGE_TWEET,SENTIMENT_TWEET,TOPIC_TWEET);")) 
echo "tweet: ".$conn->error."<br/>";

if(!$conn->query(
            "LOAD DATA INFILE '".$hcwd."' INTO TABLE hashtag(ID_TWEET,TXT_HASHTAG) SET ID_HASHTAG = NULL;")) 
echo "hashtag: ".$conn->error."<br/>";

$conn->close();

unset($_SESSION["uploadfiles"]);
$_SESSION["upass"] = 0;

fclose($myfile);
fclose($myfile2);

unlink(getcwd().'/txt_files/tweetsfile.txt');
unlink(getcwd().'/txt_files/hashtagsfile.txt');

header('Location: topic.php');

?>