/*==============================================================*/
/* Nom de SGBD :  MySQL 5.6                                     */
/* Date de création :  11/05/2016 00:01:13                      */
/*==============================================================*/


drop table if exists HASHTAG;
drop table if exists TWEET;

/*==============================================================*/
/* Table : HASHTAG                                              */
/*==============================================================*/
create table HASHTAG
(
   ID_HASHTAG           int(10) not null AUTO_INCREMENT,
   ID_TWEET         	INT(10) UNSIGNED NOT NULL,
   TXT_HASHTAG          varchar(20) NOT NULL,
   primary key (ID_HASHTAG)
) ENGINE = MyISAM;

/*==============================================================*/
/* Table : TWEET                                                */
/*==============================================================*/
create table TWEET
(
   ID_TWEET             INT(10) UNSIGNED NOT NULL,
   DATE_TWEET           date NOT NULL,
   LANGUAGE_TWEET       ENUM('deutche','english','french','italia','spanish') NOT NULL,
   SENTIMENT_TWEET      ENUM('negative','neutral','positive') NOT NULL,
   TOPIC_TWEET          ENUM('Against_eu','For_eu','None') NOT NULL,
   primary key (ID_TWEET)
) ENGINE = MyISAM;

alter table HASHTAG add constraint FK_ASSOCIATION_3 foreign key (ID_TWEET)
      references TWEET (ID_TWEET) on delete cascade on update cascade;
      
create index all_tweet on tweet(topic_tweet,date_tweet,language_tweet,sentiment_tweet);
create index date_index on tweet(date_tweet);