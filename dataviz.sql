/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  30/04/2016 03:24:52                      */
/*==============================================================*/


drop table if exists HASHTAG;

drop table if exists LANGUAGE;

drop table if exists SENTIMENT;

drop table if exists TOPIC;

drop table if exists TWEET;

drop table if exists TWEET_HASHTAG;

drop table if exists TWEET_LANGUAGE;

drop table if exists TWEET_TOPIC;

/*==============================================================*/
/* Table : HASHTAG                                              */
/*==============================================================*/
create table HASHTAG
(
   ID_HASHTAG           int not null,
   ID_TWEET             int not null,
   TXT_HASHTAG          varchar(50),
   SCORE_HASHTAG        decimal,
   primary key (ID_HASHTAG)
);

/*==============================================================*/
/* Table : LANGUAGE                                             */
/*==============================================================*/
create table LANGUAGE
(
   ID_LANGUAGE          int not null,
   TXT_LANGUAGE         varchar(50),
   primary key (ID_LANGUAGE)
);

/*==============================================================*/
/* Table : SENTIMENT                                            */
/*==============================================================*/
create table SENTIMENT
(
   ID_SENTIMENT         int not null,
   TXT_SENTIMENT        varchar(50),
   primary key (ID_SENTIMENT)
);

/*==============================================================*/
/* Table : TOPIC                                                */
/*==============================================================*/
create table TOPIC
(
   ID_TOPIC             int not null,
   TXT_TOPIC            varchar(50),
   primary key (ID_TOPIC)
);

/*==============================================================*/
/* Table : TWEET                                                */
/*==============================================================*/
create table TWEET
(
   ID_TWEET             int not null,
   TXT_TWEET            text,
   LANGUAGE_TWEET       varchar(50),
   SENTIMENT_TWEET      varchar(50),
   TOPIC_TWEET          varchar(50),
   primary key (ID_TWEET)
);

/*==============================================================*/
/* Table : TWEET_HASHTAG                                        */
/*==============================================================*/
create table TWEET_HASHTAG
(
   ID_TWEET             int not null,
   ID_SENTIMENT         int not null,
   SCORE_SENTIMENT      decimal,
   primary key (ID_TWEET, ID_SENTIMENT)
);

/*==============================================================*/
/* Table : TWEET_LANGUAGE                                       */
/*==============================================================*/
create table TWEET_LANGUAGE
(
   ID_TWEET             int not null,
   ID_LANGUAGE          int not null,
   SCORE_LANGUAGE       decimal,
   primary key (ID_TWEET, ID_LANGUAGE)
);

/*==============================================================*/
/* Table : TWEET_TOPIC                                          */
/*==============================================================*/
create table TWEET_TOPIC
(
   ID_TWEET             int not null,
   ID_TOPIC             int not null,
   SCORE_TOPIC          decimal,
   primary key (ID_TWEET, ID_TOPIC)
);

alter table HASHTAG add constraint FK_ASSOCIATION_3 foreign key (ID_TWEET)
      references TWEET (ID_TWEET) on delete restrict on update restrict;

alter table TWEET_HASHTAG add constraint FK_ASSOCIATION_6 foreign key (ID_TWEET)
      references TWEET (ID_TWEET) on delete restrict on update restrict;

alter table TWEET_HASHTAG add constraint FK_ASSOCIATION_7 foreign key (ID_SENTIMENT)
      references SENTIMENT (ID_SENTIMENT) on delete restrict on update restrict;

alter table TWEET_LANGUAGE add constraint FK_ASSOCIATION_1 foreign key (ID_TWEET)
      references TWEET (ID_TWEET) on delete restrict on update restrict;

alter table TWEET_LANGUAGE add constraint FK_ASSOCIATION_2 foreign key (ID_LANGUAGE)
      references LANGUAGE (ID_LANGUAGE) on delete restrict on update restrict;

alter table TWEET_TOPIC add constraint FK_ASSOCIATION_4 foreign key (ID_TWEET)
      references TWEET (ID_TWEET) on delete restrict on update restrict;

alter table TWEET_TOPIC add constraint FK_ASSOCIATION_5 foreign key (ID_TOPIC)
      references TOPIC (ID_TOPIC) on delete restrict on update restrict;

