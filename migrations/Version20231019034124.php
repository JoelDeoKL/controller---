<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019034124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cote (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, cote DOUBLE PRECISION NOT NULL, nom_etudiant VARCHAR(255) NOT NULL, postnom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, promotion VARCHAR(255) NOT NULL, date_cotation DATE NOT NULL, provenance VARCHAR(255) NOT NULL, INDEX IDX_3DD722C9A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, entreprise_id INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, duree VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, observation LONGTEXT DEFAULT NULL, date_demande DATE NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_2694D7A5DDEAB1A3 (etudiant_id), INDEX IDX_2694D7A5A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, nom_departement VARCHAR(255) NOT NULL, description_departement LONGTEXT NOT NULL, observation LONGTEXT DEFAULT NULL, nombre_heure INT NOT NULL, date_creation DATE NOT NULL, INDEX IDX_C1765B63A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, description_entreprise LONGTEXT NOT NULL, adresse_entreprise VARCHAR(255) DEFAULT NULL, telephone_entreprise VARCHAR(255) DEFAULT NULL, etat_entreprise VARCHAR(255) DEFAULT NULL, secteur_entreprise VARCHAR(255) NOT NULL, date_creation DATE DEFAULT NULL, date_validation DATE DEFAULT NULL, email_entreprise VARCHAR(255) NOT NULL, nombre_place INT DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, rccm VARCHAR(255) NOT NULL, idnat VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D19FA60E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, postnom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone_etudiant VARCHAR(255) NOT NULL, etat_etudiant VARCHAR(255) DEFAULT NULL, promotion VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, UNIQUE INDEX UNIQ_717E22E3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, departement_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description_tache LONGTEXT NOT NULL, etat VARCHAR(255) NOT NULL, observation LONGTEXT DEFAULT NULL, date_creation DATE NOT NULL, date_fermeture DATE DEFAULT NULL, INDEX IDX_93872075DDEAB1A3 (etudiant_id), INDEX IDX_93872075CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE validation (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, nom_etudiant VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, duree VARCHAR(255) NOT NULL, observation LONGTEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, date_validation DATE NOT NULL, INDEX IDX_16AC5B6EA4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cote ADD CONSTRAINT FK_3DD722C9A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B63A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6EA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cote DROP FOREIGN KEY FK_3DD722C9A4AEAFEA');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5DDEAB1A3');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5A4AEAFEA');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B63A4AEAFEA');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075DDEAB1A3');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075CCF9E01E');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6EA4AEAFEA');
        $this->addSql('DROP TABLE cote');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE validation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
