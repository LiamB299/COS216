CREATE TABLE users (
	id char(13),
    name varchar(30),
    surname varchar(30),
    email varchar(30) NOT NULL,
    password varchar(150) NOT NULL, 
    API_Key varchar(100) NOT NULL, 
    secret char(10) NOT NULL,
    PRIMARY KEY(email)
);

CREATE TABLE preferences (
	`key` VARCHAR(100) NOT NULL,
	theme char (1),
	genre char(1),
	platform char(1),
	score char(1),
	PRIMARY KEY(`key`),
	FOREIGN KEY(`key`) REFERENCES users(API_Key)
);

CREATE TABLE user_ratings (
	`key` VARCHAR(100) NOT NULL,
	gametitle VARCHAR(100) NOT NULL,
	rating integer,
	artwork VARCHAR(200),
	metacritic integer,
	PRIMARY  KEY(`key`,gametitle),
	FOREIGN KEY(`key`) REFERENCES users(API_Key)
);

CREATE TABLE friends (
	user1 VARCHAR(100) NOT NULL,
	user2 VARCHAR(100) NOT NULL,
	accepted BIT(1),
	PRIMARY KEY(user1, user2)
);

CREATE TABLE tracker (
	videoID varchar(150) NOT NULL,
    `key` varchar(100) NOT NULL,
    `timestamp` VARCHAR(20),
    videostamp double,
    PRIMARY KEY(`key`, videoID)
);

CREATE TABLE comments (
	`key` VARCHAR(100) NOT NULL,
    videoID varchar(150) NOT NULL,
    `timestamp` VARCHAR(20) NOT NULL,
    videostamp double,
    `comment` VARCHAR(200),
    PRIMARY KEY(`key`, videoID, timestamp)
);
