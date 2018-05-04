CREATE DATABASE bok CHARACTER SET utf8;

CREATE TABLE users (
    id int(11) primary key auto_increment,
    login varchar(255),
    password varchar(255),
    role varchar(11)
);

CREATE TABLE conversation (
    id int(11) primary key auto_increment,
    client_id int(11) not null,
    support_id int(11),
    conversation varchar(255) not null,
    date date not null,
    foreign key (client_id) references users(id),
    foreign key (support_id) references users(id)
    );

CREATE TABLE message (
    id int(11) primary key auto_increment,
    conversation_id int(11) not null,
    sender_id int(11) not null,
    message varchar(255) not null,
    datetime datetime not null,
    foreign key (conversation_id) references conversation(id),
    foreign key (sender_id) references users(id)
    );
