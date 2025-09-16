<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250915095404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT fk_b26681edffeca31');
        $this->addSql('DROP INDEX idx_b26681edffeca31');
        $this->addSql('ALTER TABLE evenement RENAME COLUMN bailleurs_id TO bailleur_id');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E57B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B26681E57B5D0A2 ON evenement (bailleur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT FK_B26681E57B5D0A2');
        $this->addSql('DROP INDEX IDX_B26681E57B5D0A2');
        $this->addSql('ALTER TABLE evenement RENAME COLUMN bailleur_id TO bailleurs_id');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT fk_b26681edffeca31 FOREIGN KEY (bailleurs_id) REFERENCES bailleur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b26681edffeca31 ON evenement (bailleurs_id)');
    }
}
