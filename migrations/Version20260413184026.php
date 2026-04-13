<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260413184026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE utilisateur_jeu');
        $this->addSql('ALTER TABLE utilisateur ADD temps_de_jeu INT DEFAULT NULL, ADD statut VARCHAR(50) DEFAULT NULL, ADD note INT DEFAULT NULL, ADD date_ajout_jeu DATE DEFAULT NULL, ADD platform_jouee VARCHAR(50) DEFAULT NULL, ADD jeu_id INT DEFAULT NULL, DROP nom, DROP prenom, DROP is_verified');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B38C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B38C9E392E ON utilisateur (jeu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_jeu (id INT AUTO_INCREMENT NOT NULL, temps_de_jeu INT NOT NULL, statut VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, note INT DEFAULT NULL, date_ajout DATE NOT NULL, platform_jouee VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, utilisateur_id INT NOT NULL, jeu_id INT NOT NULL, INDEX IDX_FA831C6FB88E14F (utilisateur_id), INDEX IDX_FA831C68C9E392E (jeu_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B38C9E392E');
        $this->addSql('DROP INDEX IDX_1D1C63B38C9E392E ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD nom VARCHAR(100) NOT NULL, ADD prenom VARCHAR(100) NOT NULL, ADD is_verified TINYINT NOT NULL, DROP temps_de_jeu, DROP statut, DROP note, DROP date_ajout_jeu, DROP platform_jouee, DROP jeu_id');
    }
}
