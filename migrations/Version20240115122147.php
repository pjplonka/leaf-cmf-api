<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240115122147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Base migration - element and values tables.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE element_date_time_value_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE element_string_value_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE element (uuid UUID NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN element.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE element_date_time_value (id INT NOT NULL, element_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, value TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_87C657A71F1F2A24 ON element_date_time_value (element_id)');
        $this->addSql('COMMENT ON COLUMN element_date_time_value.element_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN element_date_time_value.value IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE element_string_value (id INT NOT NULL, element_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_61B67AA41F1F2A24 ON element_string_value (element_id)');
        $this->addSql('COMMENT ON COLUMN element_string_value.element_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE element_date_time_value ADD CONSTRAINT FK_87C657A71F1F2A24 FOREIGN KEY (element_id) REFERENCES element (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE element_string_value ADD CONSTRAINT FK_61B67AA41F1F2A24 FOREIGN KEY (element_id) REFERENCES element (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE element_date_time_value_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE element_string_value_id_seq CASCADE');
        $this->addSql('ALTER TABLE element_date_time_value DROP CONSTRAINT FK_87C657A71F1F2A24');
        $this->addSql('ALTER TABLE element_string_value DROP CONSTRAINT FK_61B67AA41F1F2A24');
        $this->addSql('DROP TABLE element');
        $this->addSql('DROP TABLE element_date_time_value');
        $this->addSql('DROP TABLE element_string_value');
    }
}
