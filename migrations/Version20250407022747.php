<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250407022747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE blessure (id INT AUTO_INCREMENT NOT NULL, athlete_id INT NOT NULL, type_blessure VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_blessure DATETIME NOT NULL, date_reprise DATETIME NOT NULL, INDEX IDX_56D071A2FE6BCB8B (athlete_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE dossiermedical (id INT AUTO_INCREMENT NOT NULL, athlete_id INT NOT NULL, dernier_checkup DATETIME NOT NULL, allergies VARCHAR(255) NOT NULL, vaccinations VARCHAR(255) NOT NULL, etat_athlete VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_6699B4F0FE6BCB8B (athlete_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE entrainment (id INT AUTO_INCREMENT NOT NULL, equipe_id INT NOT NULL, installation_sportive_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, INDEX IDX_C96EBE976D861B89 (equipe_id), INDEX IDX_C96EBE9793BABF94 (installation_sportive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, coach_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, division ENUM('JEUNES', 'AMATEUR', 'PRO'), sport ENUM('FOOTBALL', 'BASKETBALL', 'HANDBALL'), is_local TINYINT(1) NOT NULL, INDEX IDX_2449BA153C105691 (coach_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, installation_sportive_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, etat VARCHAR(50) NOT NULL, type_equipement VARCHAR(50) NOT NULL, image_url VARCHAR(255) DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_B8B4C6F393BABF94 (installation_sportive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE exercice (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type_exercice VARCHAR(50) NOT NULL, duree_minutes INT NOT NULL, sets INT NOT NULL, reps INT NOT NULL, image_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE exercice_entrainment (id INT AUTO_INCREMENT NOT NULL, entrainment_id INT NOT NULL, exercice_id INT NOT NULL, INDEX IDX_E22E927F4E51A4E5 (entrainment_id), INDEX IDX_E22E927F89D40298 (exercice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE installationsportive (id INT NOT NULL, manager_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, type_installation VARCHAR(50) NOT NULL, adresse VARCHAR(255) NOT NULL, capacite INT NOT NULL, is_disponible TINYINT(1) NOT NULL, image_url VARCHAR(255) NOT NULL, INDEX IDX_1D1894D0783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE matchsportif (id INT AUTO_INCREMENT NOT NULL, tournois_id INT DEFAULT NULL, equipe1_id INT DEFAULT NULL, equipe2_id INT DEFAULT NULL, date DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, INDEX IDX_8AD05A0F752534C (tournois_id), INDEX IDX_8AD05A0F4265900C (equipe1_id), INDEX IDX_8AD05A0F50D03FE2 (equipe2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE performanceathlete (id INT AUTO_INCREMENT NOT NULL, athlete_id INT NOT NULL, match_id INT NOT NULL, minutes_jouees INT DEFAULT NULL, buts INT DEFAULT NULL, passes_decisives INT DEFAULT NULL, tirs INT DEFAULT NULL, interceptions INT DEFAULT NULL, fautes INT DEFAULT NULL, cartons_jaunes INT DEFAULT NULL, cartons_rouges INT DEFAULT NULL, rebonds INT DEFAULT NULL, INDEX IDX_59E04AC0FE6BCB8B (athlete_id), INDEX IDX_59E04AC02ABEACD6 (match_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE performanceequipe (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, tournois_id INT DEFAULT NULL, victoires INT NOT NULL, pertes INT NOT NULL, rang INT NOT NULL, INDEX IDX_F6D1E1166D861B89 (equipe_id), INDEX IDX_F6D1E116752534C (tournois_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tournois (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, sport ENUM('FOOTBALL', 'BASKETBALL', 'HANDBALL'), date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, role ENUM('ADMIN', 'MANAGER', 'COACH', 'ATHLETE'), email VARCHAR(180) NOT NULL, hashed_password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, status ENUM('ACTIVE', 'INACTIVE'), image_url VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), INDEX IDX_1D1C63B36D861B89 (equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blessure ADD CONSTRAINT FK_56D071A2FE6BCB8B FOREIGN KEY (athlete_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dossiermedical ADD CONSTRAINT FK_6699B4F0FE6BCB8B FOREIGN KEY (athlete_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entrainment ADD CONSTRAINT FK_C96EBE976D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entrainment ADD CONSTRAINT FK_C96EBE9793BABF94 FOREIGN KEY (installation_sportive_id) REFERENCES installationsportive (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipe ADD CONSTRAINT FK_2449BA153C105691 FOREIGN KEY (coach_id) REFERENCES utilisateur (id) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F393BABF94 FOREIGN KEY (installation_sportive_id) REFERENCES installationsportive (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE exercice_entrainment ADD CONSTRAINT FK_E22E927F4E51A4E5 FOREIGN KEY (entrainment_id) REFERENCES entrainment (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE exercice_entrainment ADD CONSTRAINT FK_E22E927F89D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE installationsportive ADD CONSTRAINT FK_1D1894D0783E3463 FOREIGN KEY (manager_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchsportif ADD CONSTRAINT FK_8AD05A0F752534C FOREIGN KEY (tournois_id) REFERENCES tournois (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchsportif ADD CONSTRAINT FK_8AD05A0F4265900C FOREIGN KEY (equipe1_id) REFERENCES equipe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchsportif ADD CONSTRAINT FK_8AD05A0F50D03FE2 FOREIGN KEY (equipe2_id) REFERENCES equipe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE performanceathlete ADD CONSTRAINT FK_59E04AC0FE6BCB8B FOREIGN KEY (athlete_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE performanceathlete ADD CONSTRAINT FK_59E04AC02ABEACD6 FOREIGN KEY (match_id) REFERENCES matchsportif (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE performanceequipe ADD CONSTRAINT FK_F6D1E1166D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE performanceequipe ADD CONSTRAINT FK_F6D1E116752534C FOREIGN KEY (tournois_id) REFERENCES tournois (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B36D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE SET NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE blessure DROP FOREIGN KEY FK_56D071A2FE6BCB8B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dossiermedical DROP FOREIGN KEY FK_6699B4F0FE6BCB8B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entrainment DROP FOREIGN KEY FK_C96EBE976D861B89
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entrainment DROP FOREIGN KEY FK_C96EBE9793BABF94
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA153C105691
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F393BABF94
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE exercice_entrainment DROP FOREIGN KEY FK_E22E927F4E51A4E5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE exercice_entrainment DROP FOREIGN KEY FK_E22E927F89D40298
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE installationsportive DROP FOREIGN KEY FK_1D1894D0783E3463
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchsportif DROP FOREIGN KEY FK_8AD05A0F752534C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchsportif DROP FOREIGN KEY FK_8AD05A0F4265900C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matchsportif DROP FOREIGN KEY FK_8AD05A0F50D03FE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE performanceathlete DROP FOREIGN KEY FK_59E04AC0FE6BCB8B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE performanceathlete DROP FOREIGN KEY FK_59E04AC02ABEACD6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE performanceequipe DROP FOREIGN KEY FK_F6D1E1166D861B89
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE performanceequipe DROP FOREIGN KEY FK_F6D1E116752534C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B36D861B89
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE blessure
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE dossiermedical
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE entrainment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE equipe
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE equipement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE exercice
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE exercice_entrainment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE installationsportive
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE matchsportif
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE performanceathlete
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE performanceequipe
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tournois
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
