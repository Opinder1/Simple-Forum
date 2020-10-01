create database main;

use main;

-- For simplicity the password is not hashed
create table users (userid INT auto_increment primary key, email VARCHAR(30), username VARCHAR(20), password VARCHAR(20));

create table comments (commentid INT auto_increment primary key, posterid INT, chatid INT, content VARCHAR(200), FOREIGN KEY (posterid) REFERENCES users(userid));

create table chats (chatid INT auto_increment primary key, creatorid INT, topicid INT, name VARCHAR(20), FOREIGN KEY (creatorid) REFERENCES users(userid));

create table topics (topicid INT auto_increment primary key, name VARCHAR(20));

create table moderators (userid INT, topicid INT, PRIMARY KEY (userid, topicid), permissions INT);

-- Example Topics
INSERT INTO topics (name) VALUES ("general");

INSERT INTO topics (name) VALUES ("faq");

INSERT INTO topics (name) VALUES ("applications");

-- An example user
INSERT INTO users (email, username, password) VALUES ("name@example.com", "name", "password");

-- An example chat
iNSERT INTO chats (creatorid, topicid, name) VALUES (1, 1, "testchat");