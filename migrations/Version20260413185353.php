<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260413185353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_1D1C63B38C9E392E ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD nom VARCHAR(100) NOT NULL, ADD prenom VARCHAR(100) NOT NULL, ADD avatar VARCHAR(255) DEFAULT NULL, DROP jeu_id, CHANGE temps_de_jeu temps_de_jeu TIME DEFAULT NULL, CHANGE platform_jouee platform_jouee VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD jeu_id INT DEFAULT NULL, DROP nom, DROP prenom, DROP avatar, CHANGE temps_de_jeu temps_de_jeu INT DEFAULT NULL, CHANGE platform_jouee platform_jouee VARCHAR(50) DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_1D1C63B38C9E392E ON utilisateur (jeu_id)');
    }
}
