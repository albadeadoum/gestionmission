<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250926084945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE agent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE assurance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE bailleur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE chauffeur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE evenement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE moto_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE piece_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE signateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_action_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vehicule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE agent (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, service VARCHAR(255) NOT NULL, lien_empl VARCHAR(255) NOT NULL, fonction VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE assurance (id INT NOT NULL, vehicule_id INT DEFAULT NULL, moto_id INT DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, debut DATE NOT NULL, fin DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_386829AE4A4A3511 ON assurance (vehicule_id)');
        $this->addSql('CREATE INDEX IDX_386829AE78B8F2AC ON assurance (moto_id)');
        $this->addSql('CREATE TABLE bailleur (id INT NOT NULL, nom VARCHAR(255) NOT NULL, taux_ag DOUBLE PRECISION NOT NULL, taux_ox DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE chauffeur (id INT NOT NULL, numero DOUBLE PRECISION NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naiss DATE DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, statut VARCHAR(60) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE evenement (id INT NOT NULL, vehicule_id INT DEFAULT NULL, chauffeur_id INT DEFAULT NULL, bailleur_id INT DEFAULT NULL, mission_id INT DEFAULT NULL, signateur_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, debut DATE NOT NULL, fin DATE NOT NULL, description VARCHAR(255) DEFAULT NULL, background_color VARCHAR(255) NOT NULL, border_color VARCHAR(255) NOT NULL, text_color VARCHAR(255) NOT NULL, dotation VARCHAR(60) DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, destination VARCHAR(255) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B26681E4A4A3511 ON evenement (vehicule_id)');
        $this->addSql('CREATE INDEX IDX_B26681E85C0B3BE ON evenement (chauffeur_id)');
        $this->addSql('CREATE INDEX IDX_B26681E57B5D0A2 ON evenement (bailleur_id)');
        $this->addSql('CREATE INDEX IDX_B26681EBE6CAE90 ON evenement (mission_id)');
        $this->addSql('CREATE INDEX IDX_B26681E9159A997 ON evenement (signateur_id)');
        $this->addSql('COMMENT ON COLUMN evenement.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE evenement_agent (evenement_id INT NOT NULL, agent_id INT NOT NULL, PRIMARY KEY(evenement_id, agent_id))');
        $this->addSql('CREATE INDEX IDX_B5213065FD02F13 ON evenement_agent (evenement_id)');
        $this->addSql('CREATE INDEX IDX_B52130653414710B ON evenement_agent (agent_id)');
        $this->addSql('CREATE TABLE mission (id INT NOT NULL, bailleur_id INT DEFAULT NULL, objet VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9067F23C57B5D0A2 ON mission (bailleur_id)');
        $this->addSql('CREATE TABLE moto (id INT NOT NULL, immatriculation VARCHAR(255) NOT NULL, marque VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) NOT NULL, utilisateur VARCHAR(255) DEFAULT NULL, date_affec DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE piece (id INT NOT NULL, vehicule_id INT DEFAULT NULL, event_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date DATE NOT NULL, quantitite VARCHAR(255) DEFAULT NULL, observation VARCHAR(255) NOT NULL, cout DOUBLE PRECISION DEFAULT NULL, garage VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_44CA0B234A4A3511 ON piece (vehicule_id)');
        $this->addSql('CREATE INDEX IDX_44CA0B2371F7E88B ON piece (event_id)');
        $this->addSql('CREATE TABLE signateur (id INT NOT NULL, nom VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, fonction VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, mission_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, create_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D649BE6CAE90 ON "user" (mission_id)');
        $this->addSql('CREATE TABLE user_action (id INT NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN user_action.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE vehicule (id INT NOT NULL, imatriculation VARCHAR(255) NOT NULL, marque VARCHAR(255) DEFAULT NULL, nbchassis VARCHAR(255) DEFAULT NULL, nbmoteur VARCHAR(255) DEFAULT NULL, puissace VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) NOT NULL, compteur VARCHAR(255) NOT NULL, vidange DOUBLE PRECISION DEFAULT NULL, pneus DOUBLE PRECISION DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, direction VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN vehicule.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE78B8F2AC FOREIGN KEY (moto_id) REFERENCES moto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E85C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E57B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E9159A997 FOREIGN KEY (signateur_id) REFERENCES signateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement_agent ADD CONSTRAINT FK_B5213065FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evenement_agent ADD CONSTRAINT FK_B52130653414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C57B5D0A2 FOREIGN KEY (bailleur_id) REFERENCES bailleur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B234A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B2371F7E88B FOREIGN KEY (event_id) REFERENCES evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649BE6CAE90 FOREIGN KEY (mission_id) REFERENCES evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE agent_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE assurance_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE bailleur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE chauffeur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE evenement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mission_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE moto_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE piece_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE signateur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_action_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vehicule_id_seq CASCADE');
        $this->addSql('ALTER TABLE assurance DROP CONSTRAINT FK_386829AE4A4A3511');
        $this->addSql('ALTER TABLE assurance DROP CONSTRAINT FK_386829AE78B8F2AC');
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT FK_B26681E4A4A3511');
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT FK_B26681E85C0B3BE');
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT FK_B26681E57B5D0A2');
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT FK_B26681EBE6CAE90');
        $this->addSql('ALTER TABLE evenement DROP CONSTRAINT FK_B26681E9159A997');
        $this->addSql('ALTER TABLE evenement_agent DROP CONSTRAINT FK_B5213065FD02F13');
        $this->addSql('ALTER TABLE evenement_agent DROP CONSTRAINT FK_B52130653414710B');
        $this->addSql('ALTER TABLE mission DROP CONSTRAINT FK_9067F23C57B5D0A2');
        $this->addSql('ALTER TABLE piece DROP CONSTRAINT FK_44CA0B234A4A3511');
        $this->addSql('ALTER TABLE piece DROP CONSTRAINT FK_44CA0B2371F7E88B');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649BE6CAE90');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE assurance');
        $this->addSql('DROP TABLE bailleur');
        $this->addSql('DROP TABLE chauffeur');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE evenement_agent');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE moto');
        $this->addSql('DROP TABLE piece');
        $this->addSql('DROP TABLE signateur');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_action');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
