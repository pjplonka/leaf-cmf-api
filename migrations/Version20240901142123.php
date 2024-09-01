<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240901142123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation to allow parent element';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE element_parent_value_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE element_parent_value (id INT NOT NULL, element_id UUID DEFAULT NULL, value UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_798BB59A1F1F2A24 ON element_parent_value (element_id)');
        $this->addSql('CREATE INDEX IDX_798BB59A1D775834 ON element_parent_value (value)');
        $this->addSql('COMMENT ON COLUMN element_parent_value.element_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN element_parent_value.value IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE element_parent_value ADD CONSTRAINT FK_798BB59A1F1F2A24 FOREIGN KEY (element_id) REFERENCES element (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE element_parent_value ADD CONSTRAINT FK_798BB59A1D775834 FOREIGN KEY (value) REFERENCES element (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE element_parent_value_id_seq CASCADE');
        $this->addSql('ALTER TABLE element_parent_value DROP CONSTRAINT FK_798BB59A1F1F2A24');
        $this->addSql('ALTER TABLE element_parent_value DROP CONSTRAINT FK_798BB59A1D775834');
        $this->addSql('DROP TABLE element_parent_value');
    }
}
