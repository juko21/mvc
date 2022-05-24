--
-- Insert values into articles
--
DROP TABLE IF EXISTS article;
CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
LOAD DATA LOCAL INFILE 'articles.md'
INTO TABLE article
CHARSET utf8
FIELDS
    TERMINATED BY ','
    ENCLOSED BY '"'
LINES
    TERMINATED BY '\n'
(title, content)
;

DROP TABLE IF EXISTS demographics;
CREATE TABLE demographics (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, population INT NOT NULL, gdp DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
LOAD DATA LOCAL INFILE 'swedendemo.csv'
INTO TABLE demographics
CHARSET utf8
FIELDS
    TERMINATED BY ','
    ENCLOSED BY '"'
LINES
    TERMINATED BY '\n'
IGNORE 1 LINES
(year, population, gdp)
;

DROP TABLE IF EXISTS pollution;
CREATE TABLE pollution (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, sweden DOUBLE PRECISION NOT NULL, global DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
LOAD DATA LOCAL INFILE 'pollution.csv'
INTO TABLE pollution
CHARSET utf8
FIELDS
    TERMINATED BY ','
    ENCLOSED BY '"'
LINES
    TERMINATED BY '\n'
IGNORE 1 LINES
(year, sweden, global)
;

DROP TABLE IF EXISTS indicator;
CREATE TABLE indicator (id INT AUTO_INCREMENT NOT NULL, route VARCHAR(255) NOT NULL, article_id INT NOT NULL, header VARCHAR(255) NOT NULL, multiple TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

INSERT INTO indicator (route, article_id, header, multiple)
VALUES 
    ("utslapp", 3, "Konsumtionsbaserade utsläpp i Sverige och andra länder", 1),
    ("matsvinn", 4, "Matsvinn i Sverige", 0),
    ("atervinning", 5, "Återvinning och bortskaffning", 0)
;

DROP TABLE IF EXISTS chartdata;
CREATE TABLE chartdata (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, indicator_id INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
INSERT INTO chartdata (article_id, indicator_id, type)
VALUES 
    (6, 1, "line"),
    (7, 1, "line"),
    (8, 1, "line"),
    (9, 2, "bar"),
    (10, 2, "bar"),
    (11, 2, "bar"),
    (12, 3, "line"),
    (13, 3, "line"),
    (14, 3, "line")
;

DROP TABLE IF EXISTS foodwaste;
CREATE TABLE foodwaste (id INT AUTO_INCREMENT NOT NULL, sector VARCHAR(255) NOT NULL, y2012 INT NOT NULL, y2014 INT NOT NULL, y2016 INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
LOAD DATA LOCAL INFILE 'foodwaste.csv'
INTO TABLE foodwaste
CHARSET utf8
FIELDS
    TERMINATED BY ','
    ENCLOSED BY '"'
LINES
    TERMINATED BY '\n'
IGNORE 1 LINES
(sector, y2012, y2014, y2016)
;

DROP TABLE IF EXISTS recycling;
CREATE TABLE recycling (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, recycling INT NOT NULL, other INT NOT NULL, dumping INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
LOAD DATA LOCAL INFILE 'recycling.csv'
INTO TABLE recycling
CHARSET utf8
FIELDS
    TERMINATED BY ','
    ENCLOSED BY '"'
LINES
    TERMINATED BY '\n'
IGNORE 1 LINES
(year, recycling, other, dumping)
;