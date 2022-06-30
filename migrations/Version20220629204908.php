<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629204908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added password table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE password_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE password (id INT NOT NULL, user_id INT NOT NULL, website VARCHAR(100) NOT NULL, login VARCHAR(100) NOT NULL, password VARCHAR(500) NOT NULL, description TEXT DEFAULT NULL, salt VARCHAR(20) NOT NULL, changed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_public BOOLEAN NOT NULL, use_pin BOOLEAN NOT NULL, days_to_password_change SMALLINT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_35C246D5A76ED395 ON password (user_id)');
        $this->addSql('ALTER TABLE password ADD CONSTRAINT FK_35C246D5A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE password_id_seq CASCADE');
        $this->addSql('DROP TABLE password');
    }
}
