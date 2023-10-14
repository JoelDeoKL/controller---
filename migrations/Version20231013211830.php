<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013211830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande ADD etat VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tache ADD departement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_93872075CCF9E01E ON tache (departement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP etat');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075CCF9E01E');
        $this->addSql('DROP INDEX IDX_93872075CCF9E01E ON tache');
        $this->addSql('ALTER TABLE tache DROP departement_id');
    }
}
