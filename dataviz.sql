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
   ID_HASHTAG           int not null AUTO_INCREMENT,
   ID_TWEET         	int not null,
   TXT_HASHTAG          varchar(30),
   primary key (ID_HASHTAG)
) ENGINE = MyISAM;

/*==============================================================*/
/* Table : TWEET                                                */
/*==============================================================*/
create table TWEET
(
   ID_TWEET             int not null,
   DATE_TWEET           date,
   LANGUAGE_TWEET       varchar(10),
   SENTIMENT_TWEET      varchar(10),
   TOPIC_TWEET          varchar(10),
   primary key (ID_TWEET)
) ENGINE = MyISAM;

alter table HASHTAG add constraint FK_ASSOCIATION_3 foreign key (ID_TWEET)
      references TWEET (ID_TWEET) on delete cascade on update cascade;