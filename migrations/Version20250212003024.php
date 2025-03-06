<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212003024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance_moto DROP CONSTRAINT fk_238e2bdfb288c3e3');
        $this->addSql('ALTER TABLE assurance_moto DROP CONSTRAINT fk_238e2bdf78b8f2ac');
        $this->addSql('ALTER TABLE assurance_vehicule DROP CONSTRAINT fk_9dc01d3cb288c3e3');
        $this->addSql('ALTER TABLE assurance_vehicule DROP CONSTRAINT fk_9dc01d3c4a4a3511');
        $this->addSql('DROP TABLE assurance_moto');
        $this->addSql('DROP TABLE assurance_vehicule');
        $this->addSql('ALTER TABLE assurance ADD vehicule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assurance ADD moto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE78B8F2AC FOREIGN KEY (moto_id) REFERENCES moto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_386829AE4A4A3511 ON assurance (vehicule_id)');
        $this->addSql('CREATE INDEX IDX_386829AE78B8F2AC ON assurance (moto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE assurance_moto (assurance_id INT NOT NULL, moto_id INT NOT NULL, PRIMARY KEY(assurance_id, moto_id))');
        $this->addSql('CREATE INDEX idx_238e2bdf78b8f2ac ON assurance_moto (moto_id)');
        $this->addSql('CREATE INDEX idx_238e2bdfb288c3e3 ON assurance_moto (assurance_id)');
        $this->addSql('CREATE TABLE assurance_vehicule (assurance_id INT NOT NULL, vehicule_id INT NOT NULL, PRIMARY KEY(assurance_id, vehicule_id))');
        $this->addSql('CREATE INDEX idx_9dc01d3c4a4a3511 ON assurance_vehicule (vehicule_id)');
        $this->addSql('CREATE INDEX idx_9dc01d3cb288c3e3 ON assurance_vehicule (assurance_id)');
        $this->addSql('ALTER TABLE assurance_moto ADD CONSTRAINT fk_238e2bdfb288c3e3 FOREIGN KEY (assurance_id) REFERENCES assurance (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assurance_moto ADD CONSTRAINT fk_238e2bdf78b8f2ac FOREIGN KEY (moto_id) REFERENCES moto (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assurance_vehicule ADD CONSTRAINT fk_9dc01d3cb288c3e3 FOREIGN KEY (assurance_id) REFERENCES assurance (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assurance_vehicule ADD CONSTRAINT fk_9dc01d3c4a4a3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assurance DROP CONSTRAINT FK_386829AE4A4A3511');
        $this->addSql('ALTER TABLE assurance DROP CONSTRAINT FK_386829AE78B8F2AC');
        $this->addSql('DROP INDEX IDX_386829AE4A4A3511');
        $this->addSql('DROP INDEX IDX_386829AE78B8F2AC');
        $this->addSql('ALTER TABLE assurance DROP vehicule_id');
        $this->addSql('ALTER TABLE assurance DROP moto_id');
    }
}
