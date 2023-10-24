<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024044335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cote ADD etudiant_id INT DEFAULT NULL, DROP nom_etudiant, DROP postnom, DROP prenom');
        $this->addSql('ALTER TABLE cote ADD CONSTRAINT FK_3DD722C9DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_3DD722C9DDEAB1A3 ON cote (etudiant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cote DROP FOREIGN KEY FK_3DD722C9DDEAB1A3');
        $this->addSql('DROP INDEX IDX_3DD722C9DDEAB1A3 ON cote');
        $this->addSql('ALTER TABLE cote ADD nom_etudiant VARCHAR(255) NOT NULL, ADD postnom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, DROP etudiant_id');
    }
}
