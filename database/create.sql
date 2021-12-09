#
# SQL om de social database aan te maken en
# de images tabel daar aan toe te voegen
#
CREATE DATABASE IF NOT EXISTS social;
CREATE TABLE IF NOT EXISTS social.images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    filename VARCHAR(40) NOT NULL,
    original_filename VARCHAR(255) NOT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;