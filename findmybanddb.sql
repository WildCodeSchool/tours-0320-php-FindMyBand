-- Exported from QuickDBD: https://www.quickdatabasediagrams.com/
-- NOTE! If you have used non-SQL datatypes in your design, you will have to change these here.

-- Exported from QuickDBD: https://www.quickdatabasediagrams.com/
-- Link to schema: https://app.quickdatabasediagrams.com/
-- NOTE! If you have used non-SQL datatypes in your design, you will have to change these here.
-- Exported from QuickDBD: https://www.quickdatabasediagrams.com/
-- NOTE! If you have used non-SQL datatypes in your design, you will have to change these here.

CREATE TABLE `group` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `name` varchar(255)  NOT NULL ,
    `email` varchar(255)  NOT NULL ,
    `description` TEXT  NOT NULL ,
    `password` varchar(255)   NOT NULL ,
    `city_id` int  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `musician` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `pseudo` varchar(200)  NOT NULL ,
    `password` varchar(255)   NOT NULL ,
    `email` varchar(255)  NOT NULL ,
    `description` TEXT  NULL ,
    `city_id` int  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `city` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `name` varchar(255)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `mastery_levels` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `level` varchar(50)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `instrument` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `name` varchar(100)  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

CREATE TABLE `instrument_played` (
    `instrument_id` int  NOT NULL ,
    `musician_id` int  NOT NULL ,
    `mastery_levels_id` int  NOT NULL 
);

CREATE TABLE `search` (
    `id` int AUTO_INCREMENT NOT NULL ,
    `instrument_id` int  NOT NULL ,
    `group_id` int  NOT NULL ,
    `mastery_levels_id` int  NOT NULL ,
    PRIMARY KEY (
        `id`
    )
);

ALTER TABLE `group` ADD CONSTRAINT `fk_group_city_id` FOREIGN KEY(`city_id`)
REFERENCES `city` (`id`);

ALTER TABLE `musician` ADD CONSTRAINT `fk_musician_city_id` FOREIGN KEY(`city_id`)
REFERENCES `city` (`id`);

ALTER TABLE `instrument_played` ADD CONSTRAINT `fk_instrument_played_instrument_id` FOREIGN KEY(`instrument_id`)
REFERENCES `instrument` (`id`);

ALTER TABLE `instrument_played` ADD CONSTRAINT `fk_instrument_played_musician_id` FOREIGN KEY(`musician_id`)
REFERENCES `musician` (`id`);

ALTER TABLE `instrument_played` ADD CONSTRAINT `fk_instrument_played_mastery_levels_id` FOREIGN KEY(`mastery_levels_id`)
REFERENCES `mastery_levels` (`id`);

ALTER TABLE `search` ADD CONSTRAINT `fk_search_instrument_id` FOREIGN KEY(`instrument_id`)
REFERENCES `instrument` (`id`);

ALTER TABLE `search` ADD CONSTRAINT `fk_search_group_id` FOREIGN KEY(`group_id`)
REFERENCES `group` (`id`);

ALTER TABLE `search` ADD CONSTRAINT `fk_search_mastery_levels_id` FOREIGN KEY(`mastery_levels_id`)
REFERENCES `mastery_levels` (`id`);

