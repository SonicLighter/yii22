CREATE DATABASE IF NOT EXISTS yii2;

USE yii2;

CREATE TABLE IF NOT EXISTS users(
  id int NOT NULL AUTO_INCREMENT,
  username varchar(30),
  password varchar(30),
  authKey varchar(30),
  accessToken varchar(30),
  admin int,
  PRIMARY KEY(id)
);

INSERT INTO users (username, password, authKey, accessToken, admin) VALUES ('admin1','admin1','token1key','1-token','1');
INSERT INTO users (username, password, authKey, accessToken, admin) VALUES ('user1','user1','token2key','2-token','0');
