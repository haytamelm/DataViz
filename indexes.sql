CREATE INDEX all_tweet_index ON tweet (date_tweet,language_tweet,sentiment_tweet,topic_tweet);

DROP INDEX all_tweet_index ON tweet;

explain SELECT COUNT(*) FROM TWEET USE INDEX (all_tweet_index) WHERE TOPIC_TWEET = 'None' AND DATE_TWEET = '2016-02-02';

show index from tweet;

SELECT COUNT(*) FROM TWEET WHERE TOPIC_TWEET = 'None' AND ( DATE_TWEET BETWEEN '2016-02-01' AND '2016-02-20' );



SELECT COUNT(*) FROM TWEET IGNORE INDEX (date_tweet_index) WHERE DATE_TWEET = '2016-02-02';

http://stackoverflow.com/questions/6593765/how-to-use-index-in-select-statement

USE INDEX (topic_tweet_index)