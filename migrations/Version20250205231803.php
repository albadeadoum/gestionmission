<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250205231803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE assurance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE assurance (id INT NOT NULL, vehicule_id INT DEFAULT NULL, moto_id INT DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, debut DATE NOT NULL, fin DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_386829AE4A4A3511 ON assurance (vehicule_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_386829AE78B8F2AC ON assurance (moto_id)');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE78B8F2AC FOREIGN KEY (moto_id) REFERENCES moto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE assurance_id_seq CASCADE');
        $this->addSql('ALTER TABLE assurance DROP CONSTRAINT FK_386829AE4A4A3511');
        $this->addSql('ALTER TABLE assurance DROP CONSTRAINT FK_386829AE78B8F2AC');
        $this->addSql('DROP TABLE assurance');
    }
}
