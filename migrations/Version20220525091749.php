<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525091749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chartdata ADD CONSTRAINT FK_6B27932A4402854A FOREIGN KEY (indicator_id) REFERENCES indicator (id)');
        $this->addSql('CREATE INDEX IDX_6B27932A4402854A ON chartdata (indicator_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chartdata DROP FOREIGN KEY FK_6B27932A4402854A');
        $this->addSql('DROP INDEX IDX_6B27932A4402854A ON chartdata');
    }
}
