<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250911150857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bailleur_evenement (bailleur_id INT NOT NULL, evenement_id INT NOT NULL, PRIMARY KEY(bailleur_id, evenement_id))');
        $this->addSql('CREATE INDEX IDX_98D5546757B5D0A2 ON bailleur_evenement (bailleur_id)');
        $this->addSql('CREATE INDEX IDX_98D55467FD02F13 ON bailleur_evenement (evenement_id)');
        $this->addSql('ALTER TABLE bailleur_evenement ADD CONSTRAINT FK_98D5546757B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bailleur_evenement ADD CONSTRAINT FK_98D55467FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement_bailleur DROP CONSTRAINT fk_f5ddbc1bfd02f13');
        $this->addSql('ALTER TABLE evenement_bailleur DROP CONSTRAINT fk_f5ddbc1b57b5d0a2');
        $this->addSql('DROP TABLE evenement_bailleur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE evenement_bailleur (evenement_id INT NOT NULL, bailleur_id INT NOT NULL, PRIMARY KEY(evenement_id, bailleur_id))');
        $this->addSql('CREATE INDEX idx_f5ddbc1b57b5d0a2 ON evenement_bailleur (bailleur_id)');
        $this->addSql('CREATE INDEX idx_f5ddbc1bfd02f13 ON evenement_bailleur (evenement_id)');
        $this->addSql('ALTER TABLE evenement_bailleur ADD CONSTRAINT fk_f5ddbc1bfd02f13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement_bailleur ADD CONSTRAINT fk_f5ddbc1b57b5d0a2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bailleur_evenement DROP CONSTRAINT FK_98D5546757B5D0A2');
        $this->addSql('ALTER TABLE bailleur_evenement DROP CONSTRAINT FK_98D55467FD02F13');
        $this->addSql('DROP TABLE bailleur_evenement');
    }
}
