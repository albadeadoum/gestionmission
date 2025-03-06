<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230807225744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d649fd02f13');
        $this->addSql('DROP INDEX uniq_8d93d649fd02f13');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN evenement_id TO mission_id');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649BE6CAE90 FOREIGN KEY (mission_id) REFERENCES evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649BE6CAE90 ON "user" (mission_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649BE6CAE90');
        $this->addSql('DROP INDEX IDX_8D93D649BE6CAE90');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN mission_id TO evenement_id');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649fd02f13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649fd02f13 ON "user" (evenement_id)');
    }
}
