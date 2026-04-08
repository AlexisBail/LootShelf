<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260408182651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_jeu (id INT AUTO_INCREMENT NOT NULL, temps_de_jeu INT NOT NULL, statut VARCHAR(50) NOT NULL, note INT DEFAULT NULL, date_ajout DATE NOT NULL, platform_jouee VARCHAR(50) NOT NULL, utilisateur_id INT NOT NULL, jeu_id INT NOT NULL, INDEX IDX_FA831C6FB88E14F (utilisateur_id), INDEX IDX_FA831C68C9E392E (jeu_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE utilisateur_jeu ADD CONSTRAINT FK_FA831C6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur_jeu ADD CONSTRAINT FK_FA831C68C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_jeu DROP FOREIGN KEY FK_FA831C6FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_jeu DROP FOREIGN KEY FK_FA831C68C9E392E');
        $this->addSql('DROP TABLE utilisateur_jeu');
    }
}
