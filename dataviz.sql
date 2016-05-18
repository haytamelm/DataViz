/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  11/05/2016 00:01:13                      */
/*==============================================================*/


drop table if exists HASHTAG;
drop table if exists TWEET;

/*==============================================================*/
/* Table : HASHTAG                                              */
/*==============================================================*/
create table HASHTAG
(
   ID_HASHTAG           int not null AUTO_INCREMENT,
   DATE_HASHTAG         date,
   TXT_HASHTAG          varchar(30),
   primary key (ID_HASHTAG)
) ENGINE = MyISAM;

/*==============================================================*/
/* Table : TWEET                                                */
/*==============================================================*/
create table TWEET
(
   ID_TWEET             int not null,
   TXT_TWEET            text,
   DATE_TWEET           date,
   LANGUAGE_TWEET       varchar(10),
   SENTIMENT_TWEET      varchar(10),
   TOPIC_TWEET          varchar(10),
   primary key (ID_TWEET)
) ENGINE = MyISAM;