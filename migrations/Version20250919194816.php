<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250919194816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE mission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mission (id INT NOT NULL, bailleur_id INT DEFAULT NULL, objet VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9067F23C57B5D0A2 ON mission (bailleur_id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C57B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement ADD mission_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B26681EBE6CAE90 ON evenement (mission_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT FK_B26681EBE6CAE90');
        $this->addSql('DROP SEQUENCE mission_id_seq CASCADE');
        $this->addSql('ALTER TABLE mission DROP CONSTRAINT FK_9067F23C57B5D0A2');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP INDEX IDX_B26681EBE6CAE90');
        $this->addSql('ALTER TABLE evenement DROP mission_id');
    }
}
