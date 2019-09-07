use mysql;
drop schema if exists sql_injection;
create schema sql_injection character set UTF8 collate utf8_bin;

use sql_injection;

drop table if exists users_insecure;
create table users_insecure (
	id int primary key auto_increment not null,
	username varchar(255) not null unique,
	password varchar(255) not null
);