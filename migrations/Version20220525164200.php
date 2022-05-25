<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525164200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chartdata (id INT AUTO_INCREMENT NOT NULL, indicator_id INT NOT NULL, article_id INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_6B27932A4402854A (indicator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demographics (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, population INT NOT NULL, gdp DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE foodwaste (id INT AUTO_INCREMENT NOT NULL, sector VARCHAR(255) NOT NULL, y2012 INT NOT NULL, y2014 INT NOT NULL, y2016 INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE indicator (id INT AUTO_INCREMENT NOT NULL, route VARCHAR(255) NOT NULL, article_id INT NOT NULL, header VARCHAR(255) NOT NULL, multiple TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, demographics_id INT NOT NULL, footprint INT NOT NULL, year INT NOT NULL, UNIQUE INDEX UNIQ_7CBE7595C1571BCE (demographics_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pollution (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, sweden DOUBLE PRECISION NOT NULL, global DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recycling (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, recycling INT NOT NULL, other INT NOT NULL, dumping INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chartdata ADD CONSTRAINT FK_6B27932A4402854A FOREIGN KEY (indicator_id) REFERENCES indicator (id)');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE7595C1571BCE FOREIGN KEY (demographics_id) REFERENCES demographics (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE7595C1571BCE');
        $this->addSql('ALTER TABLE chartdata DROP FOREIGN KEY FK_6B27932A4402854A');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE chartdata');
        $this->addSql('DROP TABLE demographics');
        $this->addSql('DROP TABLE foodwaste');
        $this->addSql('DROP TABLE indicator');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE pollution');
        $this->addSql('DROP TABLE recycling');
    }
}
