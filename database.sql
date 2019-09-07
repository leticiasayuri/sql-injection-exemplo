use mysql;
drop schema if exists sql_injection;
create schema sql_injection character set UTF8 collate utf8_bin;

use sql_injection;

drop table if exists users_insecure;
create table users_insecure (
	id int primary key auto_increment not null,
	email varchar(255) not null unique,
	password varchar(255) not null
);

insert into users_insecure (email, password)
values ('allexxrodriguess@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'); -- password = 123