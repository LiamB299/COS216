CREATE TABLE Users (
	id char(13),
    name varchar(30),
    surname varchar(30),
    email varchar(30) NOT NULL,
    password varchar(100) NOT NULL, 
    API_Key varchar(100) NOT NULL, 
    secret char(10) NOT NULL,
    PRIMARY KEY(email)
);