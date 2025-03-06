<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230809103111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carburant ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carburant ADD CONSTRAINT FK_B46A330A67B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B46A330A67B3B43D ON carburant (users_id)');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d64932daad24');
        $this->addSql('DROP INDEX idx_8d93d64932daad24');
        $this->addSql('ALTER TABLE "user" DROP carburant_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE carburant DROP CONSTRAINT FK_B46A330A67B3B43D');
        $this->addSql('DROP INDEX UNIQ_B46A330A67B3B43D');
        $this->addSql('ALTER TABLE carburant DROP users_id');
        $this->addSql('ALTER TABLE "user" ADD carburant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d64932daad24 FOREIGN KEY (carburant_id) REFERENCES carburant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8d93d64932daad24 ON "user" (carburant_id)');
    }
}
