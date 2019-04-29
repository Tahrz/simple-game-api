DROP TABLE IF EXISTS player_opened_monsters;
DROP TABLE IF EXISTS monsters;
DROP TABLE IF EXISTS players;

CREATE TABLE players (
   id VARCHAR(24) unique,
   username VARCHAR(100) NOT NULL,
   health smallint NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE monsters (
    id VARCHAR(24) unique,
    name VARCHAR(100) NOT NULL,
    health smallint NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE player_opened_monsters (
   player VARCHAR(24) NOT NULL,
   monster VARCHAR(24)NOT NULL,
   opened_at timestamp,
   PRIMARY KEY (player, monster),
   FOREIGN KEY (player) REFERENCES players(id) ON UPDATE CASCADE,
   FOREIGN KEY (monster) REFERENCES monsters(id) ON UPDATE CASCADE
);