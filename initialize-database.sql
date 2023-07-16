CREATE DATABASE IF NOT EXISTS short_links_db;

CREATE TABLE IF NOT EXISTS short_links_db.short_links
(
    `id`            INT  NOT NULL AUTO_INCREMENT,
    `long_link`     TEXT NOT NULL,
    `short_link`    TEXT NOT NULL,
    `creation_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);
