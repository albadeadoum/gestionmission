<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250915093728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bailleur_evenement DROP CONSTRAINT fk_98d5546757b5d0a2');
        $this->addSql('ALTER TABLE bailleur_evenement DROP CONSTRAINT fk_98d55467fd02f13');
        $this->addSql('DROP TABLE bailleur_evenement');
        $this->addSql('ALTER TABLE evenement ADD bailleurs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EDFFECA31 FOREIGN KEY (bailleurs_id) REFERENCES bailleur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B26681EDFFECA31 ON evenement (bailleurs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE bailleur_evenement (bailleur_id INT NOT NULL, evenement_id INT NOT NULL, PRIMARY KEY(bailleur_id, evenement_id))');
        $this->addSql('CREATE INDEX idx_98d55467fd02f13 ON bailleur_evenement (evenement_id)');
        $this->addSql('CREATE INDEX idx_98d5546757b5d0a2 ON bailleur_evenement (bailleur_id)');
        $this->addSql('ALTER TABLE bailleur_evenement ADD CONSTRAINT fk_98d5546757b5d0a2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bailleur_evenement ADD CONSTRAINT fk_98d55467fd02f13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT FK_B26681EDFFECA31');
        $this->addSql('DROP INDEX IDX_B26681EDFFECA31');
        $this->addSql('ALTER TABLE evenement DROP bailleurs_id');
    }
}
