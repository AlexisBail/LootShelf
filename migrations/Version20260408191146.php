<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260408191146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD is_verified TINYINT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur_jeu ADD CONSTRAINT FK_FA831C6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur_jeu ADD CONSTRAINT FK_FA831C68C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP is_verified');
        $this->addSql('ALTER TABLE utilisateur_jeu DROP FOREIGN KEY FK_FA831C6FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_jeu DROP FOREIGN KEY FK_FA831C68C9E392E');
    }
}
