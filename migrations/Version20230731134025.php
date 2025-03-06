<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230731134025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE carburant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE carburant (id INT NOT NULL, mission_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B46A330ABE6CAE90 ON carburant (mission_id)');
        $this->addSql('ALTER TABLE carburant ADD CONSTRAINT FK_B46A330ABE6CAE90 FOREIGN KEY (mission_id) REFERENCES evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement ALTER dotation TYPE VARCHAR(60)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE carburant_id_seq CASCADE');
        $this->addSql('ALTER TABLE carburant DROP CONSTRAINT FK_B46A330ABE6CAE90');
        $this->addSql('DROP TABLE carburant');
        $this->addSql('ALTER TABLE evenement ALTER dotation TYPE VARCHAR(255)');
    }
}
