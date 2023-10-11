<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231011064915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise CHANGE adresse_entreprise adresse_entreprise VARCHAR(255) DEFAULT NULL, CHANGE telephone_entreprise telephone_entreprise VARCHAR(255) DEFAULT NULL, CHANGE etat_entreprise etat_entreprise VARCHAR(255) DEFAULT NULL, CHANGE date_creation date_creation DATE DEFAULT NULL, CHANGE nombre_place nombre_place INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise CHANGE adresse_entreprise adresse_entreprise VARCHAR(255) NOT NULL, CHANGE telephone_entreprise telephone_entreprise VARCHAR(255) NOT NULL, CHANGE etat_entreprise etat_entreprise VARCHAR(255) NOT NULL, CHANGE date_creation date_creation DATE NOT NULL, CHANGE nombre_place nombre_place INT NOT NULL');
    }
}
