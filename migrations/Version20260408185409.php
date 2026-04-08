<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260408185409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeu CHANGE genre genre VARCHAR(255) NOT NULL, CHANGE plateform_disponible plateform_disponible VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur_jeu ADD CONSTRAINT FK_FA831C6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur_jeu ADD CONSTRAINT FK_FA831C68C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeu CHANGE genre genre JSON NOT NULL, CHANGE plateform_disponible plateform_disponible JSON NOT NULL');
        $this->addSql('ALTER TABLE utilisateur_jeu DROP FOREIGN KEY FK_FA831C6FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_jeu DROP FOREIGN KEY FK_FA831C68C9E392E');
    }
}
