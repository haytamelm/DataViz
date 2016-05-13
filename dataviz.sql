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
   ID_TWEET             int not null,
   TXT_HASHTAG          varchar(20),
   primary key (ID_HASHTAG)
);

/*==============================================================*/
/* Table : TWEET                                                */
/*==============================================================*/
create table TWEET
(
   ID_TWEET             int not null,
   TXT_TWEET            text,
   DATE_TWEET           date,
   LANGUAGE_TWEET       varchar(20),
   SENTIMENT_TWEET      varchar(20),
   TOPIC_TWEET          varchar(20),
   primary key (ID_TWEET)
);

alter table HASHTAG add constraint FK_ASSOCIATION_1 foreign key (ID_TWEET)
      references TWEET (ID_TWEET) on delete cascade on update cascade;

