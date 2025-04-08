<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250408180416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE equipe CHANGE division division ENUM('JEUNES', 'AMATEUR', 'PRO'), CHANGE sport sport ENUM('FOOTBALL', 'BASKETBALL', 'HANDBALL')
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE exercice CHANGE type_exercice type_exercice ENUM('MUSCULATION', 'CARDIO', 'YOGA', 'PILATES', 'NATATION', 'HIIT', 'ZUMBA')
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tournois CHANGE sport sport ENUM('FOOTBALL', 'BASKETBALL', 'HANDBALL')
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur CHANGE role role ENUM('ADMIN', 'MANAGER', 'COACH', 'ATHLETE'), CHANGE status status ENUM('ACTIVE', 'INACTIVE')
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE equipe CHANGE division division VARCHAR(255) DEFAULT NULL, CHANGE sport sport VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE exercice CHANGE type_exercice type_exercice VARCHAR(50) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tournois CHANGE sport sport VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur CHANGE role role VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL
        SQL);
    }
}
